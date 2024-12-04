<?php
session_start();
include '../config/connection.php';

// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

$totalRevenueQuery = "SELECT SUM(amount) as totalRevenue FROM revenue WHERE transaction_type = 'debit'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult);
$totalRevenue = $totalRevenueRow['totalRevenue'] ?? 0;
// Initialize search variables


?>
<!doctype html>
<html lang="en">

<head>
    <title>Ramstar Bus</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 150px;
            }

            h2 {
                font-size: 18px;
            }
        }
    </style>

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
                    <!-- <p><?php echo $totalTerminals; ?></p> -->
                </div>
                <div class="dashboard-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <h3>Total Revenue</h3>
                    <p>₱<?php echo number_format($totalRevenue, 2); ?></p>
                </div>

                <div class="dashboard-item">
                    <i class="fas fa-car"></i>
                    <h3>Total Bus</h3>
                    <!--  <p><?php echo $totalVehicles; ?></p> -->
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Ensure jQuery is loaded first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Your custom AJAX script -->
    <script>
        function loadContent(page) {
            $.ajax({
                url: page,
                method: 'GET',
                success: function (data) {
                    $('#main-content').html(data);

                    // Reinitialize sidebar toggle after new content is loaded
                    reinitializeSidebarToggle();
                },
                error: function () {
                    alert('Failed to load content');
                }
            });
        }

        function reinitializeSidebarToggle() {
            $('#sidebarCollapse').off('click').on('click', function (event) {
                event.preventDefault(); // Prevent default action
                $('#sidebar').toggleClass('active');
            });
        }

        function toggleSidebar(event) {
            event.preventDefault(); // Prevent default action when clicking toggle button
            $('#sidebar').toggleClass('active');
        }

        // Initial call to bind the sidebar toggle button
        $(document).ready(function () {
            reinitializeSidebarToggle();
        });
    </script>

</body>

</html>