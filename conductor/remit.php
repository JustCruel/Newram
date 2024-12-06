<?php
session_start();
include '../config/connection.php';

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

$total_load = 0;

// Fetch total load based on bus number
if ($bus_number) {
    $stmtLoad = $conn->prepare("SELECT SUM(amount) FROM transactions WHERE bus_number = ? AND conductor_id = ?");
    $stmtLoad->bind_param("ss", $bus_number, $conductor_id);
    $stmtLoad->execute();
    $stmtLoad->bind_result($total_load);
    $stmtLoad->fetch();
    $stmtLoad->close();
}

$net_amount = $total_load;  // Default net amount is the total load

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_remittance'])) {
    $bus_no = $_POST['bus_no'];

    $total_load = (float) $_POST['total_load'];  // Ensure total load is a float
    $deduction_desc = $_POST['deduction_desc'];
    $deduction_amount = $_POST['deduction_amount'];
    $net_amount = $_POST['net_amount'];

    // Display the remittance receipt (before saving)
    echo "<div id='receiptPreview' style='padding:20px; background:#f0f0f0; border-radius:8px; border:1px solid #ddd;'>";
    echo "<h3>Remittance Receipt Preview</h3>";
    echo "<p><strong>Bus No:</strong> " . htmlspecialchars($bus_no) . "</p>";
    echo "<p><strong>Conductor ID:</strong> " . htmlspecialchars($conductor_name) . "</p>";
    echo "<p><strong>Total Earnings (₱):</strong> " . number_format($total_load, 2) . "</p>";

    echo "<h4>Deductions:</h4>";
    if (!empty($deduction_desc)) {
        foreach ($deduction_desc as $index => $desc) {
            echo "<p>" . htmlspecialchars($desc) . ": ₱" . number_format((float) $deduction_amount[$index], 2) . "</p>";
        }
        echo "<p><strong>Total Deductions (₱):</strong> " . number_format(array_sum(array_map('floatval', $deduction_amount)), 2) . "</p>";
    } else {
        echo "<p>No Deductions</p>";
    }

    echo "<p><strong>Net Amount (₱):</strong> " . number_format((float) $net_amount, 2) . "</p>";

    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='bus_no' value='" . htmlspecialchars($bus_no) . "'>";
    echo "<input type='hidden' name='conductor_id' value='" . htmlspecialchars($conductor_id) . "'>";
    echo "<input type='hidden' name='total_load' value='" . htmlspecialchars($total_load) . "'>";
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
    $conductor_id = $_POST['conductor_id'];
    $total_load = (float) $_POST['total_load'];  // Ensure total load is a float
    $deduction_desc = explode(',', $_POST['deduction_desc']);
    $deduction_amount = array_map('floatval', explode(',', $_POST['deduction_amount']));  // Convert deductions to floats
    $net_amount = (float) $_POST['net_amount'];  // Ensure net amount is a float

    // Insert into remittances
    $remitDate = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO remittances (bus_no, conductor_id, remit_date, total_earning, total_deductions, net_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $total_deductions = array_sum($deduction_amount);
    $stmt->bind_param("sisdds", $bus_no, $conductor_id, $remitDate, $total_load, $total_deductions, $net_amount);
    $stmt->execute();
    $remit_id = $stmt->insert_id;

    // Insert deductions
    $stmtDeduction = $conn->prepare("INSERT INTO deductions (remit_id, description, amount) VALUES (?, ?, ?)");
    foreach ($deduction_desc as $key => $desc) {
        $amount = $deduction_amount[$key];
        $stmtDeduction->bind_param("isd", $remit_id, $desc, $amount);
        $stmtDeduction->execute();
    }

    // Reset the daily revenue to 0 after remittance
    $resetRevenueStmt = $conn->prepare("UPDATE transactions SET amount = 0 WHERE bus_number = ? AND DATE(transaction_date) = CURDATE()");
    $resetRevenueStmt->bind_param("s", $bus_no);
    $resetRevenueStmt->execute();

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

$bus_number = $_SESSION['bus_number']; // Get bus number from session
$conductor_id = $_SESSION['driver_account_number']; // Get conductor ID from session
var_dump($bus_number, $conductor_id, $conductor_name);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Conductor Remittance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

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
        button {
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
    <?php include 'sidebar.php'; ?>
    <div class="container">
        <h1>Conductor Remittance</h1>

        <form id="remittanceForm" method="POST" action="">
            <label for="bus_no">Bus No:</label>
            <input type="text" id="bus_no" name="bus_no" required value="<?= htmlspecialchars($bus_number) ?>" readonly>

            <label for="conductor_name">Conductor Name:</label>
            <input type="text" id="conductor_name" name="conductor_name" required
                value="<?= htmlspecialchars($conductor_name) ?>" readonly>

            <label for="total_load">Total Load (₱):</label>
            <input type="number" id="total_load" name="total_load" step="0.01" readonly
                value="<?= htmlspecialchars($total_load) ?>">

            <div id="deductions-container">
                <button type="button" id="toggleDeductions" class="btn btn-primary">+ Deductions</button>
                <div id="deductions" style="display: none; margin-top: 10px;">
                    <h3>Deductions</h3>
                    <div class="deduction-row">
                        <input type="text" name="deduction_desc[]" placeholder="Description">
                        <input type="number" name="deduction_amount[]" step="0.01" placeholder="Amount (₱)">
                    </div>
                    <button type="button" id="addDeduction" class="btn btn-secondary">Add Deduction</button>
                </div>
            </div>

            <label for="net_amount">Net Amount (₱):</label>
            <input type="number" id="net_amount" name="net_amount" step="0.01" readonly
                value="<?= htmlspecialchars($net_amount) ?>">

            <button type="submit" name="generate_remittance" id="remitButton">Generate Remittance</button>

        </form>
    </div>

    <script>


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
            if (event.target.classList.contains('deduction-amount')) {
                let totalLoad = parseFloat(document.getElementById('total_load').value) || 0;
                let totalDeductions = 0;

                // Sum all deduction amounts
                document.querySelectorAll('.deduction-amount').forEach(function (deductionInput) {
                    let value = parseFloat(deductionInput.value);
                    if (!isNaN(value)) {
                        totalDeductions += value;
                    }
                });

                // Update the net amount field
                document.getElementById('net_amount').value = (totalLoad - totalDeductions).toFixed(2);
            }
        });
    </script>
</body>

</html>