<?php
session_start();
include '../config/connection.php';

$currentYear = date('Y');
$currentMonth = date('m');
$currentDay = date('d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedDate = $_POST['date'];
    $selectedYear = date('Y', strtotime($selectedDate));
    $selectedMonth = date('m', strtotime($selectedDate));

    $dailyRevenueQuery = "SELECT DAY(timestamp) AS day, SUM(fare) AS total_revenue 
                          FROM passenger_logs 
                          WHERE YEAR(timestamp) = '$selectedYear' 
                          AND MONTH(timestamp) = '$selectedMonth'
                          GROUP BY DAY(timestamp)";
    $dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

    if (!$dailyRevenueResult) {
        die("Database query failed: " . mysqli_error($conn));
    }

    // Populate revenue array
    $dailyRevenue = array_fill(1, date('t', strtotime("$selectedYear-$selectedMonth-01")), 0);
    while ($row = mysqli_fetch_assoc($dailyRevenueResult)) {
        $dailyRevenue[$row['day']] = $row['total_revenue'];
    }
}

?>