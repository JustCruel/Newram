<?php
session_start();
include 'config/connection.php';

$currentYear = date('Y');
$currentMonth = date('m');
$currentDay = date('d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentYear = mysqli_real_escape_string($conn, $_POST['year']);
    $currentMonth = mysqli_real_escape_string($conn, $_POST['month']);
    $includeDay = isset($_POST['include_day']) ? true : false;

    if ($includeDay && isset($_POST['day'])) {
        $currentDay = mysqli_real_escape_string($conn, $_POST['day']);
    } else {
        $currentDay = null;
    }

    // Fetch daily revenue data for the selected year and month
    $dailyRevenueQuery = "SELECT DAY(transaction_date) AS day, SUM(amount) AS total_revenue 
                          FROM revenue 
                          WHERE YEAR(transaction_date) = '$currentYear' 
                          AND MONTH(transaction_date) = '$currentMonth' 
                          AND transaction_type = 'debit'
                          GROUP BY DAY(transaction_date)";
    $dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

    if (!$dailyRevenueResult) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $dailyRevenue = array_fill(1, date('t', strtotime("$currentYear-$currentMonth-01")), 0);

    while ($row = mysqli_fetch_assoc($dailyRevenueResult)) {
        $dailyRevenue[$row['day']] = $row['total_revenue'];
    }

    $selectedDayRevenue = $currentDay !== null && isset($dailyRevenue[$currentDay]) ? $dailyRevenue[$currentDay] : array_sum($dailyRevenue);

    // Return the updated revenue display
    echo "<h3>Total Revenue</h3>";
    echo "<p>₱" . number_format($selectedDayRevenue, 2) . "</p>";
}
