<?php
session_start();
include '../config/connection.php';

// Check if the user is logged in
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Conductor' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Fetch account number from the session
$account_number = $_SESSION['account_number'];

// Fetch user balance
$balanceQuery = "SELECT balance FROM useracc WHERE account_number = ?";
$stmt = $conn->prepare($balanceQuery);
$stmt->bind_param('s', $account_number); // Use 's' for string
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close(); // Close the statement

// Fetch total fare spent by the user
$totalFareQuery = "SELECT SUM(fare) as totalFare FROM passenger_logs WHERE rfid = ?";
$totalFareStmt = $conn->prepare($totalFareQuery);
$totalFareStmt->bind_param('s', $account_number); // Use 's' for string
$totalFareStmt->execute();
$totalFareStmt->bind_result($totalFare);
$totalFareStmt->fetch();
$totalFareStmt->close(); // Close the statement
$totalFare = $totalFare ?? 0;

// Fetch the total number of trips for the user
$totalTripsQuery = "SELECT COUNT(*) as totalTrips FROM passenger_logs WHERE rfid = ?";
$totalTripsStmt = $conn->prepare($totalTripsQuery);
$totalTripsStmt->bind_param('s', $account_number); // Assuming account_number is used in the rfid field
$totalTripsStmt->execute();
$totalTripsStmt->bind_result($totalTrips);
$totalTripsStmt->fetch();
$totalTripsStmt->close(); // Close the statement

$currentDate = date('Y-m-d'); // Get today's date in 'YYYY-MM-DD' format
$recentTripsQuery = "SELECT * FROM passenger_logs WHERE rfid = ? AND DATE(timestamp) = ?";
$recentTripsStmt = $conn->prepare($recentTripsQuery);
$recentTripsStmt->bind_param('ss', $account_number, $currentDate); // Bind account number and current date
$recentTripsStmt->execute();
$recentTripsResult = $recentTripsStmt->get_result(); // Get the result
$recentTripsStmt->close(); // Close the statement
?>

<!doctype html>
<html lang="en">

<head>
    <title>User Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .dashboard-item {
            background-color: #3e64ff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: white;
            transition: all 0.3s ease;
        }

        .dashboard-item:hover {
            background-color: #365cbb;
            transform: translateY(-5px);
        }

        .dashboard-item i {
            font-size: 40px;
            margin-bottom: 20px;
        }

        .dashboard-item h3 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .dashboard-item p {
            font-size: 18px;
            font-weight: 600;
        }

        .recent-trips {
            margin-top: 30px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include "../sidebar.php"; ?>

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
                    <i class="fas fa-wallet"></i>
                    <h3>Your Balance</h3>
                    <p>₱<?php echo number_format($balance, 2); ?></p>
                </div>
                <div class="dashboard-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <h3>Total Fare Spent</h3>
                    <p>₱<?php echo number_format($totalFare, 2); ?></p>
                </div>
                <div class="dashboard-item">
                    <i class="fas fa-car"></i>
                    <h3>Recent Trips</h3>
                    <p><?php echo number_format($totalTrips); ?> Trips</p>
                </div>
            </div>

            <div class="recent-trips">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Trip History (Today)</h5>
                        <?php if ($recentTripsResult->num_rows > 0): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>From Route</th>
                                        <th>To Route</th>
                                        <th>Fare</th>
                                        <th>Conductor</th>
                                        <th>Bus Number</th>
                                        <th>Transaction Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($trip = $recentTripsResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($trip['from_route']); ?></td>
                                            <td><?php echo htmlspecialchars($trip['to_route']); ?></td>
                                            <td>₱<?php echo number_format($trip['fare'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($trip['conductor_name']); ?></td>
                                            <td><?php echo htmlspecialchars($trip['bus_number']); ?></td>
                                            <td><?php echo htmlspecialchars($trip['transaction_number']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No recent trips available for today.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
        function loadContent(page) {
            $.ajax({
                url: page,
                method: 'GET',
                success: function (data) {
                    $('#main-content').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Failed to load content:', textStatus, errorThrown);
                    alert('Failed to load content: ' + errorThrown);
                }
            });
        }

        function toggleSidebar(event) {
            event.preventDefault();
            $('#sidebar').toggleClass('active');
        }

        $(document).ready(function () {
            $('#sidebarCollapse').on('click', toggleSidebar);
        });
    </script>

</body>

</html>