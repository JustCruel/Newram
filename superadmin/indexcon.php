<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] != 'Superadmin') {
    header("Location: ../index.php");
    exit();
}

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$bus_number = isset($_SESSION['bus_number']) ? $_SESSION['bus_number'] : 'Unknown Bus Number';
$conductorac = isset($_SESSION['conductor_name']) ? $_SESSION['conductor_name'] : 'unknown conductor account number';
$driverac = isset($_SESSION['driver_name']) ? $_SESSION['driver_name'] : 'unknown driver account number';

// Fetch metrics
$userCountQuery = "SELECT COUNT(*) as userCount FROM useracc";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['userCount'] ?? 0;

$totalRevenueQuery = "SELECT SUM(amount) as totalRevenue 
                      FROM transactions 
                      WHERE transaction_type = 'Load' 
                      AND bus_number = '$bus_number'
                      AND DATE(transaction_date) = CURDATE()";

$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenue = mysqli_fetch_assoc($totalRevenueResult)['totalRevenue'] ?? 0;

// Fetch passenger count for today from the database
$passengerCountQuery = "SELECT COUNT(*) as totalPassengers 
                        FROM passenger_logs
                        WHERE DATE(timestamp) = CURDATE() AND bus_number = '$bus_number'";

$passengerCountResult = mysqli_query($conn, $passengerCountQuery);
$totalPassengers = mysqli_fetch_assoc($passengerCountResult)['totalPassengers'] ?? 0;

// Fetch passenger count by date for the chart
$passengerCountByDateQuery = "SELECT DATE(timestamp) as date, COUNT(*) as total 
                              FROM passenger_logs
                              WHERE bus_number = '$bus_number'
                              GROUP BY DATE(timestamp)";

$passengerCountByDateResult = mysqli_query($conn, $passengerCountByDateQuery);
$passengerData = [];
while ($row = mysqli_fetch_assoc($passengerCountByDateResult)) {
    $passengerData[] = $row;
}

// Fetch revenue by date for chart
$revenueByDateQuery = "SELECT DATE(transaction_date) as date, SUM(amount) as total 
                       FROM revenue 
                       WHERE transaction_type = 'debit' 
                       GROUP BY DATE(transaction_date)";
$revenueByDateResult = mysqli_query($conn, $revenueByDateQuery);
$revenueData = [];
while ($row = mysqli_fetch_assoc($revenueByDateResult)) {
    $revenueData[] = $row;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Conductor Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            width: 100%;
            height: 100%;
            min-height: 300px;
        }

        .modal-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modal-table th,
        .modal-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        h1 {
            color: #3e64ff;
        }

        /* Ensure charts are responsive */
        @media (max-width: 767px) {
            .chart-container {
                height: 250px;
                /* Make charts smaller on mobile */
            }
        }
    </style>

</head>

<body>
    <?php include "sidebar.php"; ?>

    <div id="content" class="p-4">
        <h1 class="mb-4">Conductor Dashboard</h1>

        <!-- Dashboard Metrics -->
        <!-- Dashboard Metrics -->
        <div class="dashboard">
            <div class="card text-center text-white bg-primary">
                <div class="card-body">
                    <h3><i class="fas fa-users"></i></h3>
                    <h4>Total Users</h4>
                    <p class="h2"><?php echo $userCount; ?></p>
                </div>
            </div>
            <div class="card text-center text-white bg-success">
                <div class="card-body">
                    <h3><i class="fas fa-coins"></i></h3>
                    <h4>Total Revenue</h4>
                    <p class="h2">₱<?php echo number_format($totalRevenue, 2); ?></p>
                </div>
            </div>
            <div class="card text-center text-white bg-info">
                <div class="card-body">
                    <h3><i class="fas fa-bus"></i></h3>
                    <h4>Passengers Today</h4>
                    <p class="h2"><?php echo $totalPassengers; ?></p>
                </div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title">Revenue Trends</h4>
                        <div class="chart-container" id="revenueChart"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title">Passenger Count Trends</h4>
                        <div class="chart-container" id="passengerChart"></div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Revenue Chart -->


    </div>

    <script>
        // Revenue chart
        const revenueData = <?php echo json_encode($revenueData); ?>;
        const revenueLabels = revenueData.map(item => item.date);
        const revenueValues = revenueData.map(item => item.total);

        // Set up the Revenue Chart
        const revenueOptions = {
            chart: {
                type: 'line',  // Set the chart type
                height: 400,
            },
            series: [{
                name: 'Revenue (₱)',
                data: revenueValues
            }],
            xaxis: {
                categories: revenueLabels,
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            markers: {
                size: 5,
            },
            title: {
                text: 'Revenue Trends',
                align: 'center',
            },
            yaxis: {
                title: {
                    text: 'Revenue (₱)',
                },
                min: 0,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return '₱' + val.toFixed(2);  // Format the tooltip to show currency
                    }
                }
            },
        };

        // Initialize and render the Revenue chart
        const revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
        revenueChart.render();

        // Passenger count chart
        const passengerData = <?php echo json_encode($passengerData); ?>;
        const passengerLabels = passengerData.map(item => item.date);
        const passengerCounts = passengerData.map(item => item.total);

        // Set up the Passenger Count Chart
        const passengerOptions = {
            chart: {
                type: 'bar',
                height: 400,
            },
            series: [{
                name: 'Passengers',
                data: passengerCounts
            }],
            xaxis: {
                categories: passengerLabels,
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            markers: {
                size: 5,
            },
            title: {
                text: 'Passenger Count Trends',
                align: 'center',
            },
            yaxis: {
                title: {
                    text: 'Passenger Count',
                },
                min: 0,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + ' Passengers';  // Show the number of passengers
                    }
                }
            },
        };

        // Initialize and render the Passenger Count chart
        const passengerChart = new ApexCharts(document.querySelector("#passengerChart"), passengerOptions);
        passengerChart.render();
    </script>

</body>

</html>