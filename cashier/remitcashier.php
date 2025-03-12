<?php
session_start();
include '../config/connection.php';


if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Cashier' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Ensure that the user is logged in
if (!isset($_SESSION['account_number'])) {
    header("Location: login.php");
    exit;
}





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





$total_earnings = $total_load + $total_cash;
// Rest of your remittance logic here (e.g., deductions, net amount)
$net_amount = $total_earnings; // Default to total earnings

// Generate remittance logic (after deductions, etc.)<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form values
    $bus_no = $_POST['bus_no'];
    $conductor_name = $_POST['conductor_name'];
    $conductor_id = $_POST['conductor_id'];
    $total_fare = $_POST['total_fare'];
    $total_load = $_POST['total_load'];
    $deduction_desc = $_POST['deduction_desc'] ?? [];
    $deduction_amount = $_POST['deduction_amount'] ?? [];
    $total_earnings = $total_fare + $total_load;
    $total_deductions = array_sum(array_map('floatval', $deduction_amount));
    $net_amount = $total_earnings - $total_deductions;

    // Redirect to the remittance preview page with the data
    header("Location: remittance_preview.php?bus_no=" . urlencode($bus_no) .
        "&conductor_name=" . urlencode($conductor_name) .
        "&conductor_id=" . urlencode($conductor_id) .
        "&total_fare=" . urlencode($total_fare) .
        "&total_load=" . urlencode($total_load) .
        "&total_earnings=" . urlencode($total_earnings) .
        "&total_deductions=" . urlencode($total_deductions) .
        "&net_amount=" . urlencode($net_amount) .
        "&deduction_desc=" . urlencode(implode(',', $deduction_desc)) .
        "&deduction_amount=" . urlencode(implode(',', $deduction_amount)));
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
    <link rel="stylesheet" href="../css/sidebars.css">
    <title>Conductor Remittance</title>
    <style>
        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: transparent;
            /* Make the text color transparent */
            background-image: linear-gradient(to right, #f1c40f, #e67e22);
            background-clip: text;
            -webkit-background-clip: text;
            /* WebKit compatibility */
            -webkit-text-fill-color: transparent;
            /* Ensures only the gradient is visible */
            -webkit-text-stroke: 0.5px black;
            /* Outline effect */
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
    <?php include 'sidebar.php'; ?>

    <h1>Conductor Remittance</h1>

    <form id="remittanceForm" method="POST" action="#">
        <label for="rfid_input">Scan RFID:</label>
        <input type="text" id="rfid_input" name="rfid_input" placeholder="Scan RFID here" autofocus>
        <label for="bus_no">Bus No:</label>
        <input type="text" id="bus_no" name="bus_no" required value="" readonly>

        <label for="conductor_name">Conductor Name:</label>
        <input type="text" id="conductor_name" name="conductor_name" required value="" readonly>

        <label for="conductor_id">Conductor Name:</label>
        <input type="text" id="conductor_id" name="conductor_id" required value="" readonly>

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

    <script src="../js/sidebar.js"></script>
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

        document.getElementById('remittanceForm').addEventListener('submit', function (event) {
            // Ensure form submission does not reload the page
            event.preventDefault();

            // Check if the necessary form fields are filled
            const totalLoad = parseFloat(document.getElementById('total_load').value);
            const totalFare = parseFloat(document.getElementById('total_fare').value);
            const netAmount = parseFloat(document.getElementById('net_amount').value);
            const deductions = Array.from(document.querySelectorAll('[name="deduction_amount[]"]')).map(input => parseFloat(input.value) || 0);
            const totalDeductions = deductions.reduce((sum, amount) => sum + amount, 0);

            // Check if required fields are valid
            if (isNaN(totalLoad) || isNaN(totalFare) || isNaN(netAmount)) {
                alert("Please ensure all fields are filled out correctly.");
                return;  // Prevent submission if validation fails
            }

            // Validate that net amount matches total load + fare - deductions
            const expectedNetAmount = totalLoad + totalFare - totalDeductions;
            if (Math.abs(netAmount - expectedNetAmount) > 0.01) {
                alert("Net amount does not match the expected calculation.");
                return;  // Prevent submission if net amount is incorrect
            }

            // If validation passes, submit the form using AJAX (or you can submit traditionally)
            this.submit(); // If everything is valid, allow the form to submit
        });

        document.getElementById('rfid_input').addEventListener('change', function (event) {
            event.preventDefault(); // Prevent form submission

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
                            document.getElementById('conductor_id').value = data.conductor_id || 'Unknown Conductor';
                            document.getElementById('total_load').value = data.total_load || '0.00';
                            document.getElementById('total_fare').value = data.total_fare || '0.00';
                            document.getElementById('net_amount').value = data.net_amount || '0.00';

                            // Check if conductor_id exists
                            if (data.conductor_id) {
                                let totalLoad = parseFloat(data.total_load) || 0;
                                let totalFare = parseFloat(data.total_fare) || 0;
                                let conductor_id = data.conductor_id; // Use the conductor_id directly
                                let netAmount = totalLoad + totalFare;

                                document.getElementById('net_amount').value = netAmount.toFixed(2) || '0.00';
                            } else {
                                alert('Conductor ID not found.');
                            }
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

        // Optional: Handle form submission if needed
        document.getElementById('remittanceForm').addEventListener('submit', function (event) {
            // Ensure form submission does not reload the page
            event.preventDefault();

            // Your form submission logic here
            // For example, you can send the form data using AJAX as well
        });



    </script>
</body>

</html>