<?php
session_start();
include '../config/connection.php';

// Restrict access to Admin and Superadmin roles
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest';
} else {
    // Handle case where session variables are not set
    $firstname = 'Guest';
    $lastname = '';
    $role = 'Guest';
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
    <script src="cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="../css/sidebars.css">
    <style>
      /* Dashboard Layout and General Styles */
body {
    background-color: #f8f9fa;
    color: #2d3436;
}

#main-content {
    margin-top: 10px;
    padding: 32px;
    transition: all 0.3s ease;
}

.dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

/* Dashboard Items (Cards) */
.dashboard-item {
    background: white;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.dashboard-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.dashboard-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.dashboard-item:hover::before {
    opacity: 1;
}

.dashboard-item i {
    font-size: 2.5rem;
    margin-bottom: 16px;
    background: linear-gradient(135deg,#e74c3c, #c0392b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
}

.dashboard-item h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 8px;
}

.dashboard-item p {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

/* Larger Dashboard Items (Charts) */
.dashboard-items {
    grid-column: span 2;
    background: white;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.dashboard-items:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.dashboard-items h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2e8f0;
}

/* Chart Customization */
#revenueChart, #todayRevenueChart {
    margin-top: 16px;
    min-height: 320px;
}




/* Responsive Adjustments */
@media (max-width: 1200px) {
    .dashboard-items {
        grid-column: span 1;
    }
}

@media (max-width: 768px) {
    .dashboard {
        grid-template-columns: 1fr;
    }
    
    #main-content {
        padding: 16px;
    }
    
    .dashboard-item {
        padding: 20px;
    }
}

/* ApexCharts Customization */
.apexcharts-canvas {
    background: transparent !important;
}

.apexcharts-tooltip {
    background: white !important;
    border: none !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
    border-radius: 8px !important;
}

.apexcharts-xaxis-label, .apexcharts-yaxis-label {
    fill: #64748b !important;
}

.apexcharts-grid line {
    stroke: #e2e8f0 !important;
}
  
    </style>

</head>

<body>

   
<!-- Top Bar -->
<!-- Top Bar -->
<div class="top-bar d-flex justify-content-between align-items-center p-3">
<div class="d-flex align-items-center">
        <img src="../assets/logo/logo.png" alt="Ramstar Logo" class="me-2" width="80"> <!-- Adjust the path and size as needed -->
        <h4 class="m-0">Ramstar</h4>
    </div>
    <i id="hamburger" class="fas fa-bars fa-2x"></i>
    <div class="profile d-flex align-items-center">
        <i class="fas fa-user-circle fa-2x"></i>
        <span class="ms-2">Admin</span>
        <a href="../logout.php" class="btn btn-sm btn-light ms-2">Logout</a>
    </div>
</div>


<!-- Sidebar -->
<nav class="sidebar">
    <h4>Admin Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'admindashboard.php') ? 'active' : ''; ?>"
                href="admindashboard.php">
                <i class="fa fa-home"></i> Dashboard
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'register.php') ? 'active' : ''; ?>" href="register.php">
                <i class="fa fa-user"></i> Registration
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'regemploye.php') ? 'active' : ''; ?>" href="regemploye.php">
                <i class="fa fa-user"></i> Reg Employee
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'activate.php') ? 'active' : ''; ?>" href="activate.php">
                <i class="fa fa-sticky-note"></i> Accounts
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'revenue.php') ? 'active' : ''; ?>" href="revenue.php">
                <i class="fa fa-cogs"></i> Revenue
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'fareupdate.php') ? 'active' : ''; ?>" href="fareupdate.php">
                <i class="fa fa-arrow-up-1-9"></i> Fare Update
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'businfo.php') ? 'active' : ''; ?>" href="businfo.php">
                <i class="fa fa-bus"></i> Reg Bus Info
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'busviewinfo.php') ? 'active' : ''; ?>"
                href="busviewinfo.php">
                <i class="fa fa-eye"></i> View Bus Info
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'feedbackview.php') ? 'active' : ''; ?>"
                href="feedbackview.php">
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