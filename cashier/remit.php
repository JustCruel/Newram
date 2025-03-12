<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Cashier' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_SESSION['account_number'])) {
    header("Location: login.php");
    exit;
}

$conductor_id = $_SESSION['account_number']; // Conductor's ID from session
$conductor_name = ''; // Initialize the conductor's name variable
$bus_number = '';
$total_load = 0; // Initialize the total load variable
$rfid_scan = ''; // Initialize the RFID variable

// Handle RFID scan and fetch data based on RFID
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rfid_scan'])) {
    $rfid_scan = $_POST['rfid_scan'];

    // Fetch the conductor details and bus number based on RFID scan
    $stmt = $conn->prepare("SELECT u.firstname, u.lastname, t.bus_number, SUM(t.amount) AS total_load
                            FROM useracc u
                            LEFT JOIN transactions t ON t.conductor_id = u.account_number
                            WHERE u.account_number = ? GROUP BY u.account_number, t.bus_number");
    $stmt->bind_param("s", $rfid_scan);
    $stmt->execute();
    $stmt->bind_result($firstname, $lastname, $bus_number, $total_load);
    if ($stmt->fetch()) {
        $conductor_name = $firstname . ' ' . $lastname; // Combine first and last name
    } else {
        // If RFID not found, reset values
        $conductor_name = "Unknown Conductor";
        $bus_number = "No Bus Assigned";
        $total_load = 0;
    }
    $stmt->close();
}
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
    <link rel="stylesheet" href="../css/sidebars.css">
    <title>Conductor Remittance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
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
    <div id="main-content" class="container mt-5">
        <h1>Conductor Remittance</h1>

        <form id="remittanceForm" method="POST" action="">
            <label for="rfid_scan">RFID Scan:</label>
            <input type="text" id="rfid_scan" name="rfid_scan" placeholder="Scan RFID..." required
                value="<?= htmlspecialchars($rfid_scan) ?>">

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
                value="<?= htmlspecialchars($total_load) ?>">

            <button type="submit" name="generate_remittance" id="remitButton">Generate Remittance</button>

        </form>
    </div>

    <script src="../js/sidebar.js"></script>

    <script>
        document.getElementById('rfid_scan').addEventListener('input', function () {
            var rfid = document.getElementById('rfid_scan').value;
            if (rfid.length >= 6) {
                document.getElementById('remittanceForm').submit();
            }
        });

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
            const deductionRow = document.createElement('div');
            deductionRow.classList.add('deduction-row');
            deductionRow.innerHTML = `
                <input type="text" name="deduction_desc[]" placeholder="Description">
                <input type="number" name="deduction_amount[]" step="0.01" placeholder="Amount (₱)" class="deduction-amount">
            `;
            document.getElementById('deductions').appendChild(deductionRow);
        });

        document.getElementById('remittanceForm').addEventListener('input', function (event) {
            if (event.target.classList.contains('deduction-amount')) {
                let totalLoad = parseFloat(document.getElementById('total_load').value) || 0;
                let totalDeductions = 0;

                document.querySelectorAll('.deduction-amount').forEach(function (deductionInput) {
                    let value = parseFloat(deductionInput.value);
                    if (!isNaN(value)) {
                        totalDeductions += value;
                    }
                });

                document.getElementById('net_amount').value = (totalLoad - totalDeductions).toFixed(2);
            }
        });
    </script>
</body>

</html>