
<!doctype html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: linear-gradient(135deg, #ff0000, #ff6666);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
        }

        .top-bar h4 {
            margin-top: 10px;
            margin-left: 45px;
        }

        .top-bar .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar {
            background: linear-gradient(135deg, #b30000, #ff4d4d);
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 60px;
            left: -250px;
            padding: 20px 0;
            overflow-y: auto;
            transition: left 0.3s ease;
            z-index: 1001;
        }

        .sidebar.open {
            left: 0;
        }

        h4 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }

        #main-content {
            margin-left: 170px;
            transition: margin-left 0.3s ease;
            padding-top: 60px;
        }

        #main-content.sidebar-open {
            margin-left: 250px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: #ffffff;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 16px;
            padding: 15px 20px;
            gap: 15px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar a.active {
            background-color: #3e64ff;
            border-radius: 5px;
        }

        .sidebar h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .dashboard-item {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        color: #333;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .dashboard-item i {
        font-size: 36px;
        margin-bottom: 10px;
        color: #3e64ff;
    }

    .dashboard-item h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #495057;
    }

    .dashboard-item p {
        font-size: 16px;
        font-weight: 500;
        margin: 0;
        color: #212529;
    }

    .dashboard-items {
        grid-column: span 2;
        background-color: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .dashboard-items {
            grid-column: span 1;
        }
    }

        #hamburger {
            position: fixed;
            top: 20px;
            left: 15px;
            z-index: 1002;
            cursor: pointer;
            color: #fff;
        }

        @media (max-width: 992px) {
            .dashboard-items {
                grid-column: span 1;
            }
        }

        .sidebar-divider {
            height:  1px;
            background-color: #6c757d;
            margin: 5px 0;
        }
    </style>

</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <h4>Admin Dashboard</h4>
        <div class="profile">
            <i class="fas fa-user-circle fa-2x"></i>
            <span>Admin</span>
            <a href="logout.php" class="btn btn-sm btn-light">Logout</a>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="sidebar">
        <h2>Admin Panel</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="admindashboard.php">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="register.php">
                    <i class="fa fa-user"></i> Registration
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="regemploye.php">
                    <i class="fa fa-user"></i> Reg Employee
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="activate.php">
                    <i class="fa fa-sticky-note"></i> Accounts
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="revenue.php">
                    <i class="fa fa-cogs"></i> Revenue
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="fareupdate.php">
                    <i class="fa fa-arrow-up-1-9"></i> Fare Update
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="businfo.php">
                    <i class="fa fa-bus"></i> Reg Bus Info
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="busviewinfo.php">
                    <i class="fa fa-eye"></i> View Bus Info
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="feedbackview.php">
                    <i class="fa fa-eye"></i> Feedbacks
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li class="nav-item">
                <a class="nav-link" href="../logout.php">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Hamburger Button -->
    <i id="hamburger" class="fas fa-bars fa-2x"></i>

    <!-- Main Content -->
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
                <p>3</p>
            </div>
            <div class="dashboard-item" onclick="window.location.href='revenue.php';">
                <i class="fas fa-money-bill-wave fa-2x"></i>
                <h3>Total Revenue</h3>
                <p>₱<?php echo number_format($totalRevenue, 2); ?></p>
            </div>
            <div class="dashboard-item" onclick="window.location.href='busviewinfo.php';">
                <i class="fas fa-car fa-2x"></i>
                <h3>Total Buses</h3>
                <p><?php echo $busCount; ?></p>
            </div>
            <div class="dashboard-items" onclick=" window.location.href='revenue.php';">
                <h3>Monthly Revenue Chart</h3>
                <div id="revenueChart"></div>
            </div>
            <div class="dashboard-items" onclick="window.location.href='revenue.php';">
                <h3>Today's Revenue</h3>
                <div id="todayRevenueChart"></div>
            </div>
        </div>
    </div>

    <script>
        // Monthly Revenue Chart
        var options = {
            chart: {
                type: 'line',
                height: 300
            },
            series: [{
                name: 'Monthly Revenue',
                data: [12, 19, 3, 5, 2, 3, 7]
            }],
            xaxis: {
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July']
            }
        };

        var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), options);
        revenueChart.render();

        // Today's Revenue Chart
        var todayOptions = {
            chart: {
                type: 'bar',
                height: 300
            },
            series: [{
                name: "Today's Revenue",
                data: [12, 19, 3]
            }],
            xaxis: {
                categories: ['Morning', 'Afternoon', 'Evening']
            }
        };

        var todayRevenueChart = new ApexCharts(document.querySelector("#todayRevenueChart"), todayOptions);
        todayRevenueChart.render();

        document.getElementById('hamburger').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('sidebar-open');
        });
    </script>

</body>

</html>