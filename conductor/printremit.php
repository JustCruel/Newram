<?php
require_once '../vendor/autoload.php'; // Ensure this path is correct

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
date_default_timezone_set('Asia/Manila'); // Replace 'Asia/Manila' with your desired timezone

// Retrieve the form data
$busNumber = isset($_POST['bus_no']) ? $_POST['bus_no'] : 'Unknown Bus Number';
$conductorName = isset($_POST['conductor_name']) ? $_POST['conductor_name'] : 'Unknown Conductor';


$totalLoad = isset($_POST['total_load']) ? (float) $_POST['total_load'] : 0; // Cast to float
$deductionDesc = isset($_POST['deduction_desc']) ? (array) $_POST['deduction_desc'] : [];  // Ensure this is an array
$deductionAmount = isset($_POST['deduction_amount']) ? (array) $_POST['deduction_amount'] : [];  // Ensure this is an array
$netAmount = isset($_POST['net_amount']) ? (float) $_POST['net_amount'] : 0; // Cast to float

// Prepare deductions content
$deductionsContent = '';
foreach ($deductionDesc as $index => $desc) {
    // Ensure deductionAmount is a valid float value before formatting
    $deductionsContent .= $desc . ": P" . number_format((float) $deductionAmount[$index], 2) . "\n";
}

if (empty($deductionsContent)) {
    $deductionsContent = "No Deductions\n";
}

// Set up the printer
$printerName = "smb://LYNMARIEMAPOY/POS58"; // Set correct printer name or IP address
$connector = new WindowsPrintConnector($printerName);
$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER); // Center alignment
$printer->setEmphasis(true); // Enable bold
$printer->setTextSize(1, 1); // Small text size for header
$printer->text("ZARAGOZA RAMSTAR\n");
$printer->text("TRANSPORT COOPERATIVE\n");

$printer->text("Remittance Receipt\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);
// Print the receipt

$printer->setEmphasis(false); // Disable bold

$printer->text("Date: " . date('Y-m-d H:i:s') . "\n\n");

$printer->text("Bus No: " . $busNumber . "\n");
$printer->text("Conductor: " . $conductorName . "\n");
$printer->text("Total Earnings (P): " . number_format($totalLoad, 2) . "\n");

$printer->text("\nDeductions:\n");
$printer->text($deductionsContent);

$printer->text("\nNet Amount (P): " . number_format($netAmount, 2) . "\n");

$printer->feed(3);
$printer->cut();
$printer->close();
?>