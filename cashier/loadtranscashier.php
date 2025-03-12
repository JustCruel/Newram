<?php
session_start();
require '../fpdf/fpdf.php';
include '../config/connection.php'; // Include your DB connection file

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

// Initialize variables
$dailyRevenue = [];
$totalRevenue = 0;
$showWholeMonth = false; // Initialize the variable to prevent the undefined variable warning

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedDate = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d');
    $showWholeMonth = isset($_POST['show_whole_month']); // This will now be set to true or false based on the checkbox

    $selectedMonth = date('m', strtotime($selectedDate));
    $selectedYear = date('Y', strtotime($selectedDate));
    $selectedDay = date('d', strtotime($selectedDate));

    if ($showWholeMonth) {
        $sql = "SELECT DAY(transaction_date) AS day, SUM(amount) AS total_revenue
                FROM transactions
                WHERE transaction_type = 'Load' AND MONTH(transaction_date) = ? AND YEAR(transaction_date) = ?
                GROUP BY DAY(transaction_date)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $selectedMonth, $selectedYear);
    } else {
        $sql = "SELECT SUM(amount) AS total_revenue
                FROM transactions
                WHERE transaction_type = 'Load' AND DATE(transaction_date) = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $selectedDate);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($showWholeMonth) {
        $dailyRevenue = array_fill(1, 31, 0); // Default to 0 for all days
        while ($row = $result->fetch_assoc()) {
            $dailyRevenue[(int) $row['day']] = (float) $row['total_revenue'];
        }
    } else {
        $dailyRevenue[(int) $selectedDay] = 0; // Default to 0 for the selected day
        if ($row = $result->fetch_assoc()) {
            $dailyRevenue[(int) $selectedDay] = (float) $row['total_revenue'];
        }
    }

    $stmt->close();
}

// Calculate total revenue
$totalRevenue = array_sum($dailyRevenue);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR - Daily Revenue Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="../css/sidebars.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #ffffff;
            padding: 20px;
            color: #001f3f;
            border-right: 1px solid #e0e0e0;
        }

        .main-content {
            padding: 20px;
            background-color: #ffffff;
            border-left: 1px solid #e0e0e0;
        }

        h1,
        h2 {
            color: #343a40;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3
        }

        #chart {
            width: 100%;
            height: 350px;
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
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <div id="main-content" class="container mt-5">
    <h1 class="mt-4">Daily Revenue Report</h1>
    <form method="POST" class="mb-4">
        <div class="form-group">
            <label for="selected_date">Select Date:</label>
            <input type="date" id="selected_date" name="selected_date" class="form-control"
                value="<?php echo htmlspecialchars($selectedDate); ?>">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" id="show_whole_month" name="show_whole_month" class="form-check-input" <?php echo $showWholeMonth ? 'checked' : ''; ?>>
            <label for="show_whole_month" class="form-check-label">Show Whole Month</label>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    <p>Total Revenue: <strong><?php echo number_format($totalRevenue, 2); ?></strong></p>

    <div id="chart"></div>
    <script src="../js/sidebar.js"></script>
    <script>
        window.onload = function () {
            const dailyRevenue = <?php echo json_encode(array_values($dailyRevenue)); ?>;
            updateChart(dailyRevenue);
        };

        function updateChart(dailyRevenue) {
            const categories = <?php echo json_encode($showWholeMonth ? range(1, 31) : [$selectedDay]); ?>;

            const options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Revenue',
                    data: dailyRevenue
                }],
                xaxis: {
                    categories: categories
                },
                title: {
                    text: 'Daily Revenue',
                    align: 'center'
                },
                dataLabels: {
                    enabled: true
                },
                tooltip: {
                    shared: true,
                    intersect: false
                }
            };

            const chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        }


    </script>
    </div>
    </div>
</body>

</html>