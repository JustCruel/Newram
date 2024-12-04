<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM useracc";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

$totalRevenueQuery = "SELECT SUM(amount) as totalRevenue FROM revenue WHERE transaction_type = 'debit'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult);
$totalRevenue = $totalRevenueRow['totalRevenue'] ?? 0;

// Fetch monthly revenue data for the chart
$monthlyRevenueQuery = "SELECT MONTH(transaction_date) AS month, SUM(amount) AS total FROM revenue 
                        WHERE transaction_type = 'debit' 
                        GROUP BY MONTH(transaction_date) 
                        ORDER BY MONTH(transaction_date)";
$monthlyRevenueResult = mysqli_query($conn, $monthlyRevenueQuery);

$months = [];
$revenues = [];

while ($row = mysqli_fetch_assoc($monthlyRevenueResult)) {
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 10)); // Convert month number to name
    $revenues[] = $row['total'] ?? 0;
}

// Assuming you have the user id in session
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

// Fetch user data
$query = "SELECT firstname, lastname FROM useracc WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
$stmt->fetch();
// Fetch today's revenue from passenger_logs fare
$todayRevenueQuery = "SELECT SUM(fare) as todayRevenue FROM passenger_logs 
                      WHERE DATE(timestamp) = CURDATE()";
$todayRevenueResult = mysqli_query($conn, $todayRevenueQuery);
$todayRevenueRow = mysqli_fetch_assoc($todayRevenueResult);
$todayRevenue = $todayRevenueRow['todayRevenue'] ?? 0;

?>

<!doctype html>
<html lang="en">

<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* Keep the 4 columns for regular cards */
            gap: 20px;
        }

        .dashboard-item,
        .dashboard-items {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #3e64ff;
            width: 100%;
            /* Full width for each card */
        }

        .dashboard-items {
            background-color: #fff;
            color: black;
        }

        .dashboard-items h3 {
            color: #000000;
            font-size: 20px;
        }

        .dashboard-items h2 {
            font-size: 20px;
        }

        .dashboard-item i {
            font-size: 40px;
            margin-bottom: 20px;
        }

        /* New layout for making charts bigger */
        .dashboard-items {
            grid-column: span 2;
            /* Make each chart span 2 columns */
        }

        .dashboard-items canvas {
            width: 100% !important;
            /* Make canvas fill the card */
            height: 300px !important;
            /* Increase the height of the chart */
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .dashboard {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: repeat(2, 1fr);
                /* Two columns on tablets */
            }
        }

        @media (max-width: 576px) {
            .dashboard {
                grid-template-columns: 1fr;
                /* Single column on mobile */
            }
        }
    </style>

</head>

<body>

    <?php
    include "sidebar.php";
    ?>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary" onclick="toggleSidebar(event)">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#" onclick="loadContent('home.php');">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="main-content">
            <div class="dashboard">
                <div class="dashboard-item">
                    <i class="fas fa-users"></i>
                    <h3>Registered Users</h3>
                    <p><?php echo $userCount; ?></p>
                </div>
                <div class="dashboard-item">
                    <i class="fas fa-desktop"></i>
                    <h3>Total Terminals</h3>
                </div>
                <div class="dashboard-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <h3>Total Revenue</h3>
                    <p>₱<?php echo number_format($totalRevenue, 2); ?></p>
                </div>
                <div class="dashboard-item">
                    <i class="fas fa-car"></i>
                    <h3>Total Bus</h3>
                </div>

                <!-- Revenue Chart Card -->
                <div class="dashboard-items">
                    <h3>Revenue Chart</h3>
                    <h3>Monthly Revenue Chart</h3>
                    <canvas id="revenueChart" width="400" height="200"></canvas>

                </div>

                <!-- Today's Revenue Chart Card -->
                <div class="dashboard-items">
                    <h3>Today's Revenue</h3>
                    <canvas id="todayRevenueChart" width="400" height="200"></canvas>
                </div>

            </div>

        </div>
    </div>

    <!-- Ensure jQuery is loaded first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>

    <!-- Your custom AJAX script -->
    <script>
        function loadContent(page) {
            $.ajax({
                url: page,
                method: 'GET',
                success: function (data) {
                    $('#main-content').html(data);
                },
                error: function () {
                    alert('Failed to load content');
                }
            });
        }

        function toggleSidebar(event) {
            event.preventDefault(); // Prevent default action when clicking toggle button
            $('#sidebar').toggleClass('active');
        }

        // Initial call to bind the sidebar toggle button
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', toggleSidebar);
        });

        // Initialize Revenue Chart
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'bar', // You can change this to 'bar' or 'pie' if you prefer
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: <?php echo json_encode($revenues); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Initialize Today's Revenue Chart
        var todayRevenueCtx = document.getElementById('todayRevenueChart').getContext('2d');
        var todayRevenueChart = new Chart(todayRevenueCtx, {
            type: 'bar', // You can change this to 'bar' or 'pie' if you prefer
            data: {
                labels: ['Today'], // You can change this label as needed
                datasets: [{
                    label: 'Today\'s Revenue',
                    data: [<?php echo $todayRevenue; ?>], // Today's revenue from PHP
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

</body>

</html>