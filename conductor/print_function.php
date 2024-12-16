<?php
require_once '../vendor/autoload.php'; // Ensure this path is correct

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
date_default_timezone_set('Asia/Manila'); // Replace 'Asia/Manila' with your desired timezone


$busNumber = isset($_POST['busNumber']) ? $_POST['busNumber'] : 'Unknown Bus Number';
$transactionNumber = isset($_POST['transactionNumber']) ? $_POST['transactionNumber'] : 'Unknown Transaction Number';

function printReceipt($fromRoute, $toRoute, $fareType, $totalFare, $conductorName, $busNumber, $transactionNumber, $distance, $driverName, $paymentMethod, $passengerQuantity)
{
    try {
        // Set up the printer (replace 'YourPrinterName' with your actual printer name)
        $connector = new WindowsPrintConnector("smb://LYNMARIEMAPOY/POS58");
        $printer = new Printer($connector);

        // --- Print Logo ---
        // --- Print Logo ---
        try {
            // Load logo image (ensure the path is correct)
            $logoPath = 'D:/xammp/htdocs/Newram/conductor/escpos-php.png'; // Updated to PNG
            if (!is_readable($logoPath)) {
                echo "The logo file is not readable. Check permissions.\n";
            } else {
                echo "The logo file is readable.\n";
            }
            $logo = EscposImage::load($logoPath); // Use the new image path
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->graphics($logo); // Print the logo
        } catch (Exception $e) {
            // If the logo file is not found or there is an error, handle it
            echo "Error loading logo: " . $e->getMessage();
        }

        // --- Centered Header ---
        $printer->setJustification(Printer::JUSTIFY_CENTER); // Center alignment
        $printer->setTextSize(1, 1); // Small text size for header
        $printer->text("ZARAGOZA RAMSTAR\n");
        $printer->text("TRANSPORT COOPERATIVE\n");
        $printer->text("P5\n");
        $printer->text("STUDENT/NORTH\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        // Get current date and time
        $currentDate = date("M j, Y D");  // Example: Nov 9, 2024 Sat
        $currentTime = date("h:i A");     // Example: 04:50 PM

        // Function to handle left-aligned label and centered value
        function truncateValue($value, $maxLength)
        {
            return mb_substr($value, 0, $maxLength);
        }

        function printAlignedLabelValue($printer, $label, $value, $labelWidth = 10, $lineWidth = 32)
        {
            // Pad the label to a fixed width for consistent alignment
            $formattedLabel = str_pad($label, $labelWidth);

            // Calculate remaining space for the value
            $remainingSpace = $lineWidth - strlen($formattedLabel);

            // Truncate the value to fit within the remaining space
            $truncatedValue = mb_substr($value, 0, $remainingSpace);

            // Construct and print the line without padding after truncation
            $printer->text($formattedLabel . $truncatedValue . "\n");
        }

        // Prepare the values, truncating "FROM" and "TO" to 32 characters if needed
        $fromRouteName = truncateValue(htmlspecialchars($fromRoute['route_name'] ?? 'Unknown'), 32);
        $toRouteName = truncateValue(htmlspecialchars($toRoute['route_name'] ?? 'Unknown'), 32);

        // Replace printCenteredLine calls
        printAlignedLabelValue($printer, "BUS NO.   :  ", $busNumber);
        printAlignedLabelValue($printer, "DATE      :  ", $currentDate);
        printAlignedLabelValue($printer, "TIME      :  ", $currentTime);
        printAlignedLabelValue($printer, "FROM      :  ", $fromRouteName);
        printAlignedLabelValue($printer, "TO        :  ", $toRouteName);
        printAlignedLabelValue($printer, "DISTANCE  :  ", $distance . "KM");
        printAlignedLabelValue($printer, "Driver    :  ", htmlspecialchars($driverName));
        printAlignedLabelValue($printer, "Conductor :  ", htmlspecialchars($conductorName));
        printAlignedLabelValue($printer, "TYPE      :  ", $paymentMethod);
        printAlignedLabelValue($printer, "Passenger/s:  ", $passengerQuantity);
        $printer->feed();

        $printer->setJustification(Printer::JUSTIFY_CENTER); // Center alignment for fare
        $printer->setTextSize(2, 1); // Larger text for fare display
        $printer->text("Php " . number_format($totalFare, 2) . "\n"); // Format fare with PHP and decimal points
        $printer->feed();

        // --- Thank You Message ---
        $printer->setJustification(Printer::JUSTIFY_CENTER); // Center alignment
        $printer->setTextSize(1, 1);
        $printer->text("Trans No.:  " . htmlspecialchars((string) $transactionNumber) . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER); // Center alignment
        $printer->setTextSize(1, 1);

        $printer->text("Thank you for riding with us!\n");

        // Cut the paper
        $printer->cut();

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Ensure the printer is always closed
        if (isset($printer)) {
            $printer->close();
        }
    }
}
?>