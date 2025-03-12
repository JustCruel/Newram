<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Cashier' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM useracc";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

$totalRevenueQuery = "SELECT SUM(amount) AS totalRevenue FROM transactions WHERE transaction_type = 'Load'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenue = mysqli_fetch_assoc($totalRevenueResult)['totalRevenue'] ?? 0;

// Fetch today's revenue
$todayRevenueQuery = "SELECT SUM(amount) as todayRevenue FROM transactions WHERE transaction_type = 'Load' AND DATE(transaction_date) = CURDATE()";
$todayRevenueResult = mysqli_query($conn, $todayRevenueQuery);
$todayRevenueRow = mysqli_fetch_assoc($todayRevenueResult);
$todayRevenue = $todayRevenueRow['todayRevenue'] ?? 0;

// Assuming you have the user id in session
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

$pastMonthsLoadQuery = "
    SELECT 
        MONTHNAME(transaction_date) as month, 
        SUM(amount) as totalLoad 
    FROM transactions 
    WHERE transaction_type = 'Load' 
    AND transaction_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) 
    GROUP BY YEAR(transaction_date), MONTH(transaction_date)
    ORDER BY transaction_date ASC";
$pastMonthsLoadResult = mysqli_query($conn, $pastMonthsLoadQuery);

$pastMonths = [];
$totalLoads = [];
while ($row = mysqli_fetch_assoc($pastMonthsLoadResult)) {
    $pastMonths[] = $row['month'];
    $totalLoads[] = $row['totalLoad'];
}

$monthsJson = json_encode($pastMonths);
$loadsJson = json_encode($totalLoads);

// Fetch user data
$query = "SELECT firstname, lastname FROM useracc WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
$stmt->fetch();
?>

<!doctype html>
<html lang="en">

<head>
    <title>Cashier Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/sidebars.css"> <!-- Your custom CSS -->
    <style>
        /* Dashboard Grid */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .dashboard-item {
            background-color: #007bff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: white;
        }

        .dashboard-item i {
            font-size: 40px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
            overflow-y: auto;
            border-left: 1px solid #e0e0e0;
        }

        /* Make it responsive */
        @media (max-width: 1200px) {
            .dashboard {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }

        /* Ensure the page content doesn't stretch too wide */
        #main-content {
            padding: 30px;
        }
    </style>
</head>

<body>

    <?php
    include "sidebar.php";
    ?>

    <!-- Page Content -->
    <div id="main-content" class="container mt-5">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-primary">Past Months' Total Load</h2>
                        <div id="pastMonthsChart"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-primary">Today's Total Load</h2>
                        <div id="revenueChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ensure jQuery is loaded first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/sidebar.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Total Load',
                    data: [<?php echo $todayRevenue; ?>] // Use PHP to echo the revenue data
                }],
                xaxis: {
                    categories: ['Today'] // You can customize this as needed
                }
            };

            var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
            chart.render();
        });

        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Total Load',
                    data: <?php echo $loadsJson; ?>
                }],
                xaxis: {
                    categories: <?php echo $monthsJson; ?>,
                },
                colors: ['#007bff']
            };

            var chart = new ApexCharts(document.querySelector("#pastMonthsChart"), options);
            chart.render();
        });
    </script>
</body>

</html>
