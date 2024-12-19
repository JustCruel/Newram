<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Cashier' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch user data
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

// Initialize variables for the current year, month, and day
$currentYear = date('Y');
$currentMonth = date('m');
$currentDay = date('d'); // Get current day
$dailyRevenue = [];
$selectedDayRevenue = 0;

// Set the default date to current date if not set
$selectedDate = isset($_POST['selected_date']) ? $_POST['selected_date'] : $currentYear . '-' . $currentMonth . '-' . $currentDay;
$selectedYear = date('Y', strtotime($selectedDate));
$selectedMonth = date('m', strtotime($selectedDate));
$selectedDay = date('d', strtotime($selectedDate));

// Check if checkbox is checked to show whole month
$showWholeMonth = isset($_POST['show_whole_month']) ? true : false;

// Fetch daily revenue data for the selected year and month
// Fetch revenue for the selected day or month
if ($showWholeMonth) {
    // Fetch monthly revenue data
    $dailyRevenueQuery = "SELECT DAY(transaction_date) AS day, SUM(amount) AS total_revenue 
                          FROM transactions 
                          WHERE MONTH(transaction_date) = '$selectedMonth' AND YEAR(transaction_date) = '$selectedYear'
                          AND transaction_type = 'Load'
                          GROUP BY DAY(transaction_date)";
    $dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

    if (!$dailyRevenueResult) {
        die("Database query failed: " . mysqli_error($conn));
    }

    // Initialize daily revenue for the selected month
    $dailyRevenue = [];
    for ($i = 1; $i <= 31; $i++) {
        $dailyRevenue[$i] = 0;  // Ensure every day of the month has a default value
    }

    while ($row = mysqli_fetch_assoc($dailyRevenueResult)) {
        $dailyRevenue[$row['day']] = $row['total_revenue'];
    }
} else {
    // Fetch revenue for the selected day
    $dailyRevenueQuery = "SELECT SUM(amount) AS total_revenue 
    FROM transactions 
    WHERE DATE(transaction_date) = '$selectedDate'
    AND transaction_type = 'Load'";
    $dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

    if (!$dailyRevenueResult) {
        die("Database query failed: " . mysqli_error($conn));
    }

    // Initialize the array with all zeros
    $dailyRevenue = array_fill(1, 31, 0);
    $row = mysqli_fetch_assoc($dailyRevenueResult);
    $dailyRevenue[$selectedDay] = isset($row['total_revenue']) ? $row['total_revenue'] : 0;
}

// Calculate selected day revenue
$selectedDayRevenue = isset($row['total_revenue']) ? $row['total_revenue'] : 0;

// Function to generate PDF
if (isset($_GET['generate_pdf'])) {
    require('../fpdf/fpdf.php'); // Adjust the path to the fpdf.php file

    // Get the selected date from the URL if available
    $selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : $currentYear . '-' . $currentMonth . '-' . $currentDay;
    $selectedYear = date('Y', strtotime($selectedDate));
    $selectedMonth = date('m', strtotime($selectedDate));
    $selectedDay = date('d', strtotime($selectedDate));

    // Fetch revenue for the selected day (recalculate here)
    $dailyRevenueQuery = "SELECT SUM(amount) AS total_revenue 
                          FROM transactions 
                          WHERE DATE(transaction_date) = '$selectedDate'
                          AND transaction_type = 'Load'";

    $dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

    if (!$dailyRevenueResult) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($dailyRevenueResult);
    $selectedDayRevenue = isset($row['total_revenue']) ? $row['total_revenue'] : 0;

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Revenue Report');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Year: ' . $selectedYear);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Month: ' . date("F", mktime(0, 0, 0, $selectedMonth, 1)));

    if ($selectedDay !== null) {
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Day: ' . date("F j, Y", strtotime($selectedDate)));
    }

    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Total Revenue: P' . number_format($selectedDayRevenue, 2));

    $pdf->Output('D', 'revenue_report.pdf'); // Force download the PDF
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!-- Added ApexCharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            color: #001f3f;
            display: flex;
            flex-direction: column;
            height: 100vh;
            border-right: 1px solid #e0e0e0;
        }

        .sidebar img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .button-card {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .button-card:hover {
            background-color: yellow;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #ffffff;
            border-left: 1px solid #e0e0e0;
            height: 100%;
        }

        h1 {
            color: black;
            margin-bottom: 20px;
            font-size: 24px;
        }

        h2.mt-5 {
            color: black;
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 150px;
            }
        }

        /* Chart styles */
        #revenueChart {
            width: 100%;
            height: auto;
            max-width: 1000px;
            margin: 20px auto;
        }
    </style>
</head>

<body>

    <?php
    include "../sidebar.php";
    ?>

    <!-- Page Content  -->


    <div class="main-content">
        <h1 class="mb-4">Load Transaction Report</h1>

        <!-- Date Selection Form -->
        <form method="POST" action="">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="selected_date">Select Date</label>
                    <input type="date" name="selected_date" class="form-control" id="selected_date"
                        value="<?= $selectedDate ?>">
                </div>



                <div class="col-md-3 mb-3">
                    <button type="submit" class="btn btn-primary mt-4">Generate Report</button>
                </div>
            </div>
        </form>

        <!-- Chart -->
        <div id="revenueChart"></div>

        <h2 class="mt-5">Revenue for <?php echo date("F j, Y", strtotime($selectedDate)); ?></h2>

        <p>Total Revenue for the day: P<?= number_format($selectedDayRevenue, 2) ?></p>

        <a href="?generate_pdf=true&selected_date=<?= $selectedDate ?>" class="btn btn-danger">Download PDF</a>
    </div>
    </div>
    <script src="../js/main.js"></script>
    <!-- Chart JS -->
    <script>
        $(document).ready(function () {
            // Fetch the daily revenue data from PHP
            var chartData = <?php echo json_encode($dailyRevenue); ?>;
            var categories = [];
            var isWholeMonth = <?= $showWholeMonth ? 'true' : 'false'; ?>;

            // Prepare categories for the whole month or just a selected day
            if (isWholeMonth) {
                for (var i = 1; i <= 31; i++) {
                    categories.push(i);
                }
            } else {
                categories = ['<?= $selectedDay ?>']; // Only show selected day for single date view
            }

            // Make sure the chart data is an array of numbers
            var seriesData = categories.map(function (day) {
                return chartData[day] || 0; // Default to 0 if no data exists for a given day
            });

            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Revenue',
                    data: seriesData
                }],
                xaxis: {
                    categories: categories,
                    title: {
                        text: 'Day'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Revenue (₱)'
                    }
                },
                title: {
                    text: 'Revenue for ' + (isWholeMonth ? 'the whole month of ' + '<?= date("F, Y", strtotime($selectedDate)) ?>' : 'the selected day'),
                    align: 'center'
                }
            };

            // Render the chart
            var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
            chart.render();
        });


    </script>

</body>

</html>