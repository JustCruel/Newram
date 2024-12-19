<?php
session_start();
include '../config/connection.php';

// Check if the necessary session variables are set
if (!isset($_SESSION['bus_no'], $_SESSION['conductor_name'], $_SESSION['total_cash'], $_SESSION['net_amount'], $_SESSION['deduction_desc'], $_SESSION['deduction_amount'])) {
    echo "No data available.";
    exit;
}

// Retrieve data from session
$bus_no = $_SESSION['bus_no'];
$conductor_name = $_SESSION['conductor_name'];
$total_cash = isset($_SESSION['total_cash']) ? (float) $_SESSION['total_cash'] : 0.0; // Ensure it's a float
$net_amount = isset($_SESSION['net_amount']) ? (float) $_SESSION['net_amount'] : 0.0; // Ensure it's a float
$deduction_desc = $_SESSION['deduction_desc'];
$deduction_amount = isset($_SESSION['deduction_amount']) ? array_map('floatval', $_SESSION['deduction_amount']) : []; // Convert to float

// Calculate total deductions
$total_deductions = array_sum($deduction_amount);

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
    echo "<script>alert('Remittance saved successfully! Revenue for today has been reset.'); window.location.href='remitcashier.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remittance Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container" style="padding:20px; background:#f0f0f0; border-radius:8px; border:1px solid #ddd;">
        <h3>Remittance Receipt</h3>
        <p><strong>Bus No:</strong> <?php echo htmlspecialchars($bus_no); ?></p>
        <p><strong>Conductor:</strong> <?php echo htmlspecialchars($conductor_name); ?></p>
        <p><strong>Total Fare (₱):</strong> <?php echo number_format($total_cash, 2); ?></p>
        <p><strong>Total Deductions (₱):</strong> <?php echo number_format($total_deductions, 2); ?></p>
        <p><strong>Net Amount (₱):</strong> <?php echo number_format($net_amount, 2); ?></p>

        <h4>Deductions:</h4>
        <?php if (!empty($deduction_desc)): ?>
            <?php foreach ($deduction_desc as $index => $desc): ?>
                <p><?php echo htmlspecialchars($desc); ?>: ₱<?php echo number_format($deduction_amount[$index], 2); ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Deductions</p>
        <?php endif; ?>

        <!-- Confirm & Save Form -->
        <form method="POST" action="">
            <!-- Change this to your processing script -->
            <input type="hidden" name="bus_no" value="<?php echo htmlspecialchars($bus_no); ?>">
            <input type="hidden" name="conductor_name" value="<?php echo htmlspecialchars($conductor_name); ?>">
            <input type="hidden" name="total_cash" value="<?php echo htmlspecialchars($total_cash); ?>">
            <input type="hidden" name="net_amount" value="<?php echo htmlspecialchars($net_amount); ?>">
            <input type="hidden" name="deduction_desc"
                value="<?php echo htmlspecialchars(implode(',', $deduction_desc)); ?>">
            <input type="hidden" name="deduction_amount"
                value="<?php echo htmlspecialchars(implode(',', $deduction_amount)); ?>">
            <button type="submit" name="confirm_remittance" class="btn btn-success">Confirm & Save</button>
        </form>
    </div>
</body>

</html>