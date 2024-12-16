<?php
session_start();
include '../config/connection.php';


if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Conductor' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Ensure that the user is logged in
if (!isset($_SESSION['account_number'])) {
    header("Location: login.php");
    exit;
}

$conductor_id = $_SESSION['account_number']; // Conductor's ID based on the session
$bus_number = '';

$conductor_name = ''; // Initialize the conductor's name variable

// Fetch the conductor's name based on the conductor_id
$stmt = $conn->prepare("SELECT firstname, lastname FROM useracc WHERE account_number = ?");
$stmt->bind_param("s", $conductor_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
if ($stmt->fetch()) {
    $conductor_name = $firstname . ' ' . $lastname; // Combine the first and last name
}
$stmt->close();

// Handle case where the conductor's name could not be fetched
if (empty($conductor_name)) {
    $conductor_name = "Unknown Conductor"; // Fallback value
}

// Fetch the bus number assigned to the conductor
$stmt = $conn->prepare("SELECT bus_number FROM transactions WHERE conductor_id = ? ORDER BY transaction_date DESC LIMIT 1");
$stmt->bind_param("s", $conductor_id);
$stmt->execute();
$stmt->bind_result($bus_number);
$stmt->fetch();
$stmt->close();

// If no bus number is assigned, handle the case (optional)
if (!$bus_number) {
    $bus_number = ''; // Handle the case where no bus number is assigned.
    echo "<script>alert('No bus number assigned to your account.');</script>";
}




if ($bus_number) {
    // Fetch total load transactions
    $stmtLoad = $conn->prepare("SELECT SUM(amount) FROM transactions WHERE status = 'notremitted' AND bus_number = ? AND conductor_id = ? AND DATE(transaction_date) = CURDATE()");
    $stmtLoad->bind_param("ss", $bus_number, $conductor_id);
    $stmtLoad->execute();
    $stmtLoad->bind_result($total_load);
    $stmtLoad->fetch();
    $stmtLoad->close();

    // Fetch total cash transactions (including the fare)
    $stmtCash = $conn->prepare("SELECT SUM(fare) FROM passenger_logs WHERE status = 'notremitted' AND bus_number = ? AND conductor_name = ? AND rfid = 'cash' AND DATE(timestamp) = CURDATE()");
    $stmtCash->bind_param("ss", $bus_number, $conductor_name);
    $stmtCash->execute();
    $stmtCash->bind_result($total_cash);
    $stmtCash->fetch();
    $stmtCash->close();
    // Default to 0 if NULL

    $total_cash = $total_cash ?? 0; // Default to 0 if NULL
}




$total_earnings = $total_load + $total_cash;
// Rest of your remittance logic here (e.g., deductions, net amount)
$net_amount = $total_earnings; // Default to total earnings

// Generate remittance logic (after deductions, etc.)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_remittance'])) {
    // Fetch the posted values and calculate total deductions
    $bus_no = $_POST['bus_no'];
    $deduction_desc = $_POST['deduction_desc'] ?? [];
    $deduction_amount = $_POST['deduction_amount'] ?? [];
    $total_cash = (float) $_POST['total_fare'];  // Ensure total load is a float
    $total_deductions = array_sum(array_map('floatval', $deduction_amount));
    $net_amount = $total_earnings - $total_deductions;

    // Display the remittance receipt (before saving)
    echo "<div id='receiptPreview' style='padding:20px; background:#f0f0f0; border-radius:8px; border:1px solid #ddd;'>";
    echo "<h3>Remittance Receipt Preview</h3>";
    echo "<p><strong>Bus No:</strong> " . htmlspecialchars($bus_no) . "</p>";
    echo "<p><strong>Conductor:</strong> " . htmlspecialchars($conductor_name) . "</p>";
    echo "<p><strong>Total Fare (₱):</strong> " . number_format($total_cash, 2) . "</p>";
    echo "<p><strong>Total Earnings (₱):</strong> " . number_format($net_amount, 2) . "</p>";

    echo "<h4>Deductions:</h4>";
    if (!empty($deduction_desc)) {
        foreach ($deduction_desc as $index => $desc) {
            echo "<p>" . htmlspecialchars($desc) . ": ₱" . number_format((float) $deduction_amount[$index], 2) . "</p>";
        }
        echo "<p><strong>Total Deductions (₱):</strong> " . number_format($total_deductions, 2) . "</p>";
    } else {
        echo "<p>No Deductions</p>";
    }

    echo "<p><strong>Net Amount (₱):</strong> " . number_format((float) $net_amount, 2) . "</p>";
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='bus_no' value='" . htmlspecialchars($bus_no) . "'>";
    echo "<input type='hidden' name='conductor_id' value='" . htmlspecialchars($conductor_id) . "'>";
    echo "<input type='hidden' name='total_load' value='" . htmlspecialchars($total_load) . "'>";
    echo "<input type='hidden' name='total_load' value='" . htmlspecialchars($total_cash) . "'>";
    echo "<input type='hidden' name='deduction_desc' value='" . htmlspecialchars(implode(',', $deduction_desc)) . "'>";
    echo "<input type='hidden' name='deduction_amount' value='" . htmlspecialchars(implode(',', $deduction_amount)) . "'>";
    echo "<input type='hidden' name='net_amount' value='" . htmlspecialchars($net_amount) . "'>";
    echo "<button type='submit' name='confirm_remittance' class='btn-confirm'>Confirm & Save</button>";
    echo "</form>";
    echo "</div>";

    // Exit after displaying receipt preview
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_remittance'])) {
    // Confirm and save the remittance
    $bus_no = $_POST['bus_no'];
    $conductor_id = (string) $_POST['conductor_id'];
    $total_load = (float) $_POST['total_load'];  // Ensure total load is a float
    $total_cash = (float) $_POST['total_fare'];  // Ensure total load is a float
    $deduction_desc = explode(',', $_POST['deduction_desc']);
    $deduction_amount = array_map('floatval', explode(',', $_POST['deduction_amount']));  // Convert deductions to floats
    $net_amount = (float) $_POST['net_amount'];  // Ensure net amount is a float

    // Insert into remittances
    $remitDate = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO remittances (bus_no, conductor_id, remit_date, total_earning, total_deductions, net_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $total_deductions = array_sum($deduction_amount);
    $stmt->bind_param("sssdds", $bus_no, $conductor_id, $remitDate, $total_load, $total_deductions, $net_amount);
    $stmt->execute();
    $remit_id = $stmt->insert_id;

    // Insert remittance log into remit_logs table
    $stmtRemitLog = $conn->prepare("INSERT INTO remit_logs (remit_id, bus_no, conductor_id, total_load, total_cash, total_deductions, net_amount, remit_date) VALUES (?, ?,?, ?, ?, ?, ?, ?)");
    $stmtRemitLog->bind_param("issdddds", $remit_id, $bus_no, $conductor_id, $total_load, $total_cash, $total_deductions, $net_amount, $remitDate);
    $stmtRemitLog->execute();

    // Insert deductions
    $stmtDeduction = $conn->prepare("INSERT INTO deductions (remit_id, description, amount) VALUES (?, ?, ?)");
    foreach ($deduction_desc as $key => $desc) {
        $amount = $deduction_amount[$key];
        $stmtDeduction->bind_param("isd", $remit_id, $desc, $amount);
        $stmtDeduction->execute();
    }

    // Reset the daily revenue to 0 after remittance
    $resetRevenueStmt = $conn->prepare("UPDATE transactions SET status = 'remitted' WHERE bus_number = ? AND DATE(transaction_date) = CURDATE()");
    $resetRevenueStmt->bind_param("s", $bus_no);
    $resetRevenueStmt->execute();

    $resetPassengerLogsStmt = $conn->prepare("UPDATE passenger_logs SET status = 'remitted' WHERE bus_number = ? AND DATE(timestamp) = CURDATE()");
    $resetPassengerLogsStmt->bind_param("s", $bus_no);
    $resetPassengerLogsStmt->execute();

    // Pass conductor name to printremit.php via POST
    $_POST['conductor_name'] = $conductor_name;
    include 'printremit.php';

    // Success response
    echo "<script>alert('Remittance saved successfully! Revenue for today has been reset.'); window.location.href='';</script>";
}

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

// Assuming you have the user id in session
// Ensure you have user_id in the session

$query = "SELECT firstname, lastname FROM useracc WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
$stmt->fetch();
$stmt->close(); // Close statement

if (!isset($_SESSION['bus_number']) || !isset($_SESSION['driver_account_number'])) {
    echo json_encode(['error' => 'Bus number or conductor not set in session.']);
    exit;
}

var_dump($conductor_id);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Conductor Remittance</title>
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        buttons {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #addDeduction {
            background: #007BFF;
            color: white;
            border: none;
        }

        #remitButton {
            background: #28A745;
            color: white;
            border: none;
        }
    </style>
</head>

<body>
    <?php include '../sidebar.php'; ?>
    <div class="container">
        <h1>Conductor Remittance</h1>

        <form id="remittanceForm" method="POST" action="">
            <label for="rfid_input">Scan RFID:</label>
            <input type="text" id="rfid_input" name="rfid_input" placeholder="Scan RFID here" autofocus>
            <label for="bus_no">Bus No:</label>
            <input type="text" id="bus_no" name="bus_no" required value="" readonly>

            <label for="conductor_name">Conductor Name:</label>
            <input type="text" id="conductor_name" name="conductor_name" required value="" readonly>

            <label for="total_fare">Total Fare (₱):</label>
            <input type="number" id="total_fare" name="total_fare" step="0.01" readonly value="">


            <label for="total_load">Total Load (₱):</label>
            <input type="number" id="total_load" name="total_load" step="0.01" readonly value="">

            <div id="deductions-container">
                <button type="button" id="toggleDeductions" class="btn btn-primary">+ Deductions</button>
                <div id="deductions" style="display: none; margin-top: 10px;">
                    <h3>Deductions</h3>
                    <div class="deduction-row">
                        <input type="text" name="deduction_desc[]" placeholder="Description">
                        <input type="number" name="deduction_amount[]" step="0.01" placeholder="Amount (₱)">
                    </div>
                    <button type="buttons" id="addDeduction" class="btn btn-secondary">Add Deduction</button>
                </div>
            </div>

            <label for="net_amount">Net Amount (₱):</label>
            <input type="number" id="net_amount" name="net_amount" step="0.01" readonly value="">


            <button type="submit" name="generate_remittance" id="remitButton">Generate Remittance</button>

        </form>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const totalLoadInput = document.getElementById('total_load');
            const netAmountInput = document.getElementById('net_amount');
            const deductionsContainer = document.getElementById('deductions-container');

            function calculateNetAmount() {
                const totalLoad = parseFloat(totalLoadInput.value) || 0;
                let totalDeductions = 0;

                // Sum up all deduction amounts
                document.querySelectorAll('[name="deduction_amount[]"]').forEach((input) => {
                    totalDeductions += parseFloat(input.value) || 0;
                });

                // Calculate and update the Net Amount
                netAmountInput.value = (totalLoad - totalDeductions).toFixed(2);
            }

            // Recalculate Net Amount when the total load or deductions change
            totalLoadInput.addEventListener('input', calculateNetAmount);
            deductionsContainer.addEventListener('input', calculateNetAmount);

            // Add new deduction rows dynamically
            document.getElementById('addDeduction').addEventListener('click', function () {
                const deductionRow = document.createElement('div');
                deductionRow.className = 'deduction-row';
                deductionRow.innerHTML = `
            <input type="text" name="deduction_desc[]" placeholder="Description">
            <input type="number" name="deduction_amount[]" step="0.01" placeholder="Amount (₱)">
        `;
                deductionsContainer.appendChild(deductionRow);
            });

            // Initial calculation to ensure Net Amount matches Total Load on load
            calculateNetAmount();
        });



        // Toggle the visibility of the deductions section
        document.getElementById('toggleDeductions').addEventListener('click', function () {
            const deductions = document.getElementById('deductions');
            if (deductions.style.display === 'none') {
                deductions.style.display = 'block';
                this.textContent = '- Deductions';
            } else {
                deductions.style.display = 'none';
                this.textContent = '+ Deductions';
            }
        });

        document.getElementById('addDeduction').addEventListener('click', function () {
            // Create a new deduction row
            const deductionRow = document.createElement('div');
            deductionRow.classList.add('deduction-row');

            deductionRow.innerHTML = `
            <input type="text" name="deduction_desc[]" placeholder="Description">
            <input type="number" name="deduction_amount[]" step="0.01" placeholder="Amount (₱)" class="deduction-amount">
        `;

            document.getElementById('deductions').appendChild(deductionRow);
        });

        // Automatically calculate the net amount when deductions are added or changed
        document.getElementById('remittanceForm').addEventListener('input', function (event) {
            // Check if the event target is a deduction amount input
            if (event.target.classList.contains('deduction-amount') || event.target.id === 'total_load' || event.target.id === 'total_fare') {
                let totalLoad = parseFloat(document.getElementById('total_load').value) || 0;
                let totalFare = parseFloat(document.getElementById('total_fare').value) || 0;
                let totalDeductions = 0;

                // Sum all deduction amounts
                document.querySelectorAll('.deduction-amount').forEach(function (deductionInput) {
                    let value = parseFloat(deductionInput.value);
                    if (!isNaN(value)) {
                        totalDeductions += value;
                    }
                });

                // Update the net amount field
                document.getElementById('net_amount').value = (totalLoad + totalFare - totalDeductions).toFixed(2);
            }
        });
        document.getElementById('rfid_input').addEventListener('change', function () {
            const rfid = this.value;

            if (rfid) {
                // Send RFID data to the server via AJAX
                fetch('fetch_conductor_info.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ rfid })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Populate the fields with the fetched data
                            document.getElementById('bus_no').value = data.bus_number || 'N/A';
                            document.getElementById('conductor_name').value = data.conductor_name || 'Unknown Conductor';
                            document.getElementById('total_load').value = data.total_load || '0.00';
                            document.getElementById('total_fare').value = data.total_fare;
                            document.getElementById('net_amount').value = data.net_amount || '0.00';

                            let totalLoad = parseFloat(data.total_load) || 0;
                            let totalFare = parseFloat(data.total_fare) || 0;
                            let netAmount = totalLoad + totalFare;

                            document.getElementById('net_amount').value = netAmount.toFixed(2) || '0.00';
                        } else {
                            alert(data.message || 'Error fetching conductor info.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to fetch data.');
                    });
            }
        });
    </script>
</body>

</html>