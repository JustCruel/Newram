<?php
session_start();
ob_start();

ini_set('display_errors', 0); // Suppress errors
error_reporting(0);          // Turn off error reporting

include '../config/connection.php';
include '../sidebar.php';


if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

$currentYear = date('Y');
$currentMonth = date('m');
$currentDay = date('d');
$selectedDayRevenue = 0; // Default value

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedDate = $_POST['date'] ?? date('Y-m-d');
    $selectedYear = date('Y', strtotime($selectedDate));
    $selectedMonth = date('m', strtotime($selectedDate));
    $selectedDay = date('d', strtotime($selectedDate));

    $dailyRevenueQuery = "SELECT DAY(timestamp) AS day, SUM(fare) AS total_revenue 
                          FROM passenger_logs 
                          WHERE YEAR(timestamp) = '$selectedYear' 
                          AND MONTH(timestamp) = '$selectedMonth'
                          GROUP BY DAY(timestamp)";
    $dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

    $daysInMonth = date('t', strtotime("$selectedYear-$selectedMonth-01"));
    $dailyRevenue = array_fill(1, $daysInMonth, 0);

    while ($row = mysqli_fetch_assoc($dailyRevenueResult)) {
        $dailyRevenue[$row['day']] = $row['total_revenue'];
    }

    $selectedDayRevenue = $dailyRevenue[(int) $selectedDay] ?? 0;

    header('Content-Type: application/json');
    ob_end_clean(); // Clear any unwanted output
    echo json_encode([
        'dailyRevenue' => $dailyRevenue,
        'selectedDayRevenue' => $selectedDayRevenue
    ]);

    exit;
}

$dailyRevenue = $dailyRevenue ?? [];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!-- Load ApexCharts -->
    <!-- jQuery CDN link -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    
    <style>
        h1 {
            color: black;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Revenue Report</h1>

        <!-- Filter Form -->
        <form id="filterForm" method="POST">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="date" class="form-label">Select Date</label>
                    <input type="date" id="date" name="date" class="form-control"
                        value="<?php echo "$currentYear-$currentMonth-$currentDay"; ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" class="btn btn-danger" id="generatePdfBtn">Download PDF</button>
        </form>

        <!-- Display Total Revenue -->
        <div class="mt-4" id="revenueDisplay">
            <h3>Total Revenue</h3>
            <p>₱<?php echo number_format($selectedDayRevenue, 2); ?></p>
        </div>

        <!-- Chart for daily revenue -->
        <div id="revenueChart"></div> <!-- ApexCharts container -->
    </div>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
        // Update the chart using ApexCharts
        function updateChart(dailyRevenue) {
            const labels = Object.keys(dailyRevenue).map(day => parseInt(day));
            const data = Object.values(dailyRevenue);

            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Daily Revenue',
                    data: data
                }],
                xaxis: {
                    categories: labels,
                    title: {
                        text: 'Days of the Month'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Revenue (₱)'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    opacity: 0.9
                },
                colors: ['#4bc0c0']
            };

            // Clear previous chart and render a new one
            document.querySelector("#revenueChart").innerHTML = "";
            var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
            chart.render();
        }


        window.onload = function () {
            const initialData = <?php echo json_encode($dailyRevenue); ?>;
            updateChart(initialData);
        };

        document.getElementById('filterForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch(window.location.href, {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    document.querySelector('#revenueDisplay p').textContent = `₱${parseFloat(data.selectedDayRevenue).toFixed(2)}`;
                    updateChart(data.dailyRevenue);
                })
                .catch(error => console.error('Error updating revenue data:', error));
        });


        // Handle PDF generation
        document.getElementById('generatePdfBtn').addEventListener('click', function () {
            const formData = new FormData(document.getElementById('filterForm'));

            fetch('generate_pdf.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.blob())  // PDF comes as a blob
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'Revenue_Report.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => console.error('Error generating PDF:', error));
        });
    </script>
</body>

</html>