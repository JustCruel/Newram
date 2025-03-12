<?php
session_start();
include '../config/connection.php';

$bus_no = $_GET['bus_no'] ?? '';
$conductor_name = $_GET['conductor_name'] ?? '';
$conductor_id = $_GET['conductor_id'] ?? '';
$total_fare = $_GET['total_fare'] ?? 0;
$total_load = $_GET['total_load'] ?? 0;
$total_earnings = $_GET['total_earnings'] ?? 0;
$total_deductions = $_GET['total_deductions'] ?? 0;
$net_amount = $_GET['net_amount'] ?? 0;
$deduction_desc = isset($_GET['deduction_desc']) ? explode(',', $_GET['deduction_desc']) : [];
$deduction_amount = isset($_GET['deduction_amount']) ? explode(',', $_GET['deduction_amount']) : [];

// Display the remittance receipt preview
echo "<div id='receiptPreview' class='receipt-container'>";
echo "<h3>Remittance Receipt Preview</h3>";
echo "<p><strong>Bus No:</strong> " . htmlspecialchars($bus_no) . "</p>";
echo "<p><strong>Conductor:</strong> " . htmlspecialchars($conductor_name) . "</p>";
echo "<p><strong>Conductor ID:</strong> " . htmlspecialchars($conductor_id) . "</p>";
echo "<p><strong>Total Fare (₱):</strong> " . number_format($total_fare, 2) . "</p>";
echo "<p><strong>Total Load (₱):</strong> " . number_format($total_load, 2) . "</p>";
echo "<p><strong>Total Earnings (₱):</strong> " . number_format($total_earnings, 2) . "</p>";

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

// Display the confirmation form
echo "<form method='POST' action='' class='remittance-form'>";
echo "<input type='hidden' name='bus_no' value='" . htmlspecialchars($bus_no) . "'>";
echo "<input type='hidden' name='conductor_name' value='" . htmlspecialchars($conductor_name) . "'>";
echo "<input type='hidden' name='conductor_id' value='" . htmlspecialchars($conductor_id) . "'>";
echo "<input type='hidden' name='total_fare' value='" . htmlspecialchars($total_fare) . "'>";
echo "<input type='hidden' name='total_load' value='" . htmlspecialchars($total_load) . "'>";
foreach ($deduction_desc as $index => $desc) {
    echo "<input type='hidden' name='deduction_desc[]' value='" . htmlspecialchars($desc) . "'>";
    echo "<input type='hidden' name='deduction_amount[]' value='" . htmlspecialchars($deduction_amount[$index]) . "'>";
}
echo "<input type='hidden' name='net_amount' value='" . htmlspecialchars($net_amount) . "'>";
echo "<button type='submit' name='confirm_remittance' class='btn-confirm'>Confirm & Save</button>";
echo "<a href='remitcashier.php' class='btn-back'>Back</a>";
echo "</form>";
echo "</div>";

// Process the form when 'Confirm & Save' is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_remittance'])) {
    // Extract form data
    $bus_no = $_POST['bus_no'];
    $conductor_id = (string) $_POST['conductor_id'];
    $total_load = (float) $_POST['total_load']; // Ensure total load is a float
    $total_cash = (float) $_POST['total_fare']; // Ensure total load is a float
    $deduction_desc = $_POST['deduction_desc']; // Array of deduction descriptions
    $deduction_amount = array_map('floatval', $_POST['deduction_amount']); // Convert deductions to floats
    $net_amount = (float) $_POST['net_amount']; // Ensure net amount is a float

    // Insert into remittances table
    $remitDate = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO remittances (bus_no, conductor_id, remit_date, total_earning, total_deductions, net_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $total_deductions = array_sum($deduction_amount); // Sum of deductions
    $stmt->bind_param("sssdds", $bus_no, $conductor_id, $remitDate, $total_load, $total_deductions, $net_amount);
    $stmt->execute();
    $remit_id = $stmt->insert_id;

    // Insert into remit_logs table
    $stmtRemitLog = $conn->prepare("INSERT INTO remit_logs (remit_id, bus_no, conductor_id, total_load, total_cash, total_deductions, net_amount, remit_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtRemitLog->bind_param("issdddds", $remit_id, $bus_no, $conductor_id, $total_load, $total_cash, $total_deductions, $net_amount, $remitDate);
    $stmtRemitLog->execute();

    // Insert each deduction into the deductions table
    $stmtDeduction = $conn->prepare("INSERT INTO deductions (remit_id, description, amount) VALUES (?, ?, ?)");
    foreach ($deduction_desc as $key => $desc) {
        $amount = $deduction_amount[$key];
        $stmtDeduction->bind_param("isd", $remit_id, $desc, $amount);
        $stmtDeduction->execute();
    }

    // Reset the daily revenue after remittance
    $resetRevenueStmt = $conn->prepare("UPDATE transactions SET status = 'remitted' WHERE bus_number = ? AND DATE(transaction_date) = CURDATE()");
    $resetRevenueStmt->bind_param("s", $bus_no);
    $resetRevenueStmt->execute();

    // Reset passenger logs after remittance
    $resetPassengerLogsStmt = $conn->prepare("UPDATE passenger_logs SET status = 'remitted' WHERE bus_number = ? AND DATE(timestamp) = CURDATE()");
    $resetPassengerLogsStmt->bind_param("s", $bus_no);
    $resetPassengerLogsStmt->execute();

    // Pass conductor name to printremit.php via POST
    $_POST['conductor_name'] = $conductor_name;
    include 'printremit.php';

    // Success response (JavaScript alert)
    echo "<script>alert('Remittance successfully!'); window.location.href = 'remitcashier.php';</script>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
    }
    .receipt-container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        width: 60%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h3 {
        color: #333;
        margin-bottom: 20px;
    }
    p {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
    }
    .btn-confirm, .btn-back {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    }
    .btn-confirm {
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        margin-top: 20px;
    }
    .btn-back {
        background-color: #ccc;
        color: #333;
        text-decoration: none;
        margin-top: 20px;
        margin-left: 10px;
    }
    .remittance-form {
        display: flex;
        flex-direction: column;
    }
    .btn-confirm:hover, .btn-back:hover {
        opacity: 0.9;
    }
</style>
