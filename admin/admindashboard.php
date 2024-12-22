<?php
session_start();
include '../config/connection.php';

// Restrict access to Admin and Superadmin roles
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Fetch user count
$userCountQuery = "SELECT COUNT(*) AS userCount FROM useracc";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['userCount'] ?? 0;

// Fetch total revenue
$totalRevenueQuery = "SELECT SUM(amount) AS totalRevenue FROM revenue WHERE transaction_type = 'debit'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenue = mysqli_fetch_assoc($totalRevenueResult)['totalRevenue'] ?? 0;

// Fetch total bus count
$busCountQuery = "SELECT COUNT(*) AS busCount FROM businfo";
$busCountResult = mysqli_query($conn, $busCountQuery);
$busCount = mysqli_fetch_assoc($busCountResult)['busCount'] ?? 0;

// Fetch monthly revenue data for chart
$monthlyRevenueQuery = "SELECT MONTH(transaction_date) AS month, SUM(amount) AS total 
                        FROM revenue 
                        WHERE transaction_type = 'debit' 
                        GROUP BY MONTH(transaction_date) 
                        ORDER BY MONTH(transaction_date)";
$monthlyRevenueResult = mysqli_query($conn, $monthlyRevenueQuery);

// Prepare data for the chart
$months = [];
$revenues = [];
while ($row = mysqli_fetch_assoc($monthlyRevenueResult)) {
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 10)); // Convert month number to name
    $revenues[] = $row['total'] ?? 0;
}

// Fetch today's revenue from passenger logs
$todayRevenueQuery = "SELECT SUM(fare) AS todayRevenue FROM passenger_logs WHERE DATE(timestamp) = CURDATE()";
$todayRevenueResult = mysqli_query($conn, $todayRevenueQuery);
$todayRevenue = mysqli_fetch_assoc($todayRevenueResult)['todayRevenue'] ?? 0;

?>

<!doctype html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .dashboard-item {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #3e64ff;
        }

        .dashboard-items {
            grid-column: span 2;
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #000;
        }

        .dashboard-items canvas {
            width: 100% !important;
            height: 300px !important;
        }



        @media (max-width: 992px) {
            .dashboard-items {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <?php include "../sidebar.php"; ?>

    <div id="main-content" class="container mt-4">
        <div class="dashboard">
            <div class="dashboard-item" onclick="window.location.href='activate.php';">
                <i class="fas fa-users fa-2x"></i>
                <h3>Registered Users</h3>
                <p><?php echo $userCount; ?></p>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-desktop fa-2x"></i>
                <h3>Total Terminals</h3>
                <p>3</p> <!-- Update with actual data -->
            </div>
            <div class="dashboard-item">
                <i class="fas fa-money-bill-wave fa-2x"></i>
                <h3>Total Revenue</h3>
                <p>₱<?php echo number_format($totalRevenue, 2); ?></p>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-car fa-2x"></i>
                <h3>Total Buses</h3>
                <p><?php echo $busCount; ?></p>
            </div>
            <div class="dashboard-items">
                <h3>Monthly Revenue Chart</h3>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="dashboard-items">
                <h3>Today's Revenue</h3>
                <canvas id="todayRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
        // Revenue Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: <?php echo json_encode($revenues); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Today's Revenue Chart
        new Chart(document.getElementById('todayRevenueChart'), {
            type: 'bar',
            data: {
                labels: ['Today'],
                datasets: [{
                    label: 'Today\'s Revenue',
                    data: [<?php echo $todayRevenue; ?>],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>

</html>