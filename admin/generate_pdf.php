<?php
// Include the necessary libraries (FPDF, TCPDF, etc.)
require('../fpdf/fpdf.php'); // Replace this with the actual path to your PDF library

// Fetch the necessary data (e.g., from POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'] ?? null;  // Handle if the day is optional

    // Fetch revenue data based on selected filters
    include '../config/connection.php';
    $query = "SELECT DAY(timestamp) AS day, SUM(fare) AS total_revenue 
              FROM passenger_logs 
              WHERE YEAR(timestamp) = '$year' 
              AND MONTH(timestamp) = '$month' 
              GROUP BY DAY(timestamp)";
    if ($day) {
        $query .= " AND DAY(timestamp) = '$day'";
    }
    $result = mysqli_query($conn, $query);

    // Initialize PDF
    $pdf = new FPDF(); // Assuming you're using FPDF
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Add title
    $pdf->Cell(0, 10, "Revenue Report for $year-$month", 0, 1, 'C');

    // Add content to the PDF
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(0, 10, 'Day: ' . $row['day'] . '\n - Total Revenue: P' . number_format($row['total_revenue'], 2), 0, 1);
    }

    // Output PDF
    $pdf->Output('Revenue_Report.pdf', 'D'); // 'D' forces download
}
?>