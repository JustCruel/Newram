<?php
// Fetch URL parameters
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
echo "<div id='receiptPreview' style='padding:20px; background:#f0f0f0; border-radius:8px; border:1px solid #ddd;'>";
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
echo "<form method='POST' action='save_remittance.php'>";
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
echo "<a href = 'remitcashier.php'>Back</a>";
echo "</form>";
echo "</div>";
?>