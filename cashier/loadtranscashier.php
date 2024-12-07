<?php
session_start();
include '../config/connection.php';
include_once '../check_role.php';

// Check if the user is logged in
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Cashier' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Fetch user data
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

// Assuming you have the user id in session
// Ensure you have user_id in the session

$query = "SELECT firstname, lastname FROM useracc WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
$stmt->fetch();
$stmt->close(); // Close statement

// Initialize variables for the current year, month, and day
$currentYear = date('Y');
$currentMonth = date('m');
$currentDay = date('d'); // Get current 
$dailyRevenue = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected year and month
    $currentYear = mysqli_real_escape_string($conn, $_POST['year']);
    $currentMonth = mysqli_real_escape_string($conn, $_POST['month']);
    $includeDay = isset($_POST['include_day']) ? true : false;

    // Fetch daily revenue data for the selected year and month
    $dailyRevenueQuery = "SELECT DAY(transaction_date) AS day, SUM(amount) AS total_revenue 
                          FROM transactions 
                          WHERE YEAR(transaction_date) = '$currentYear' 
                          AND MONTH(transaction_date) = '$currentMonth' 
                          AND transaction_type = 'Load'
                          GROUP BY DAY(transaction_date)";
    $dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

    if (!$dailyRevenueResult) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $dailyRevenue = array_fill(1, date('t', strtotime("$currentYear-$currentMonth-01")), 0);

    while ($row = mysqli_fetch_assoc($dailyRevenueResult)) {
        $dailyRevenue[$row['day']] = $row['total_revenue'];
    }

    if ($includeDay && isset($_POST['day'])) {
        $currentDay = mysqli_real_escape_string($conn, $_POST['day']);
    } else {
        $currentDay = null;
    }

    // Calculate selected day revenue
    $selectedDayRevenue = $currentDay !== null && isset($dailyRevenue[$currentDay]) ? $dailyRevenue[$currentDay] : array_sum($dailyRevenue);
} else {
    // Default selected day revenue is the total revenue for the current month
    $selectedDayRevenue = array_sum($dailyRevenue);
}

// Function to generate PDF
if (isset($_GET['generate_pdf'])) {
    require('../fpdf/fpdf.php'); // Adjust the path to the fpdf.php file

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Revenue Report');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Year: ' . $currentYear);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Month: ' . date("F", mktime(0, 0, 0, $currentMonth, 1)));

    if ($currentDay !== null) {
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Day: ' . $currentDay);
    }

    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'Total Revenue: ₱' . number_format($selectedDayRevenue, 2));

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            width: 500px;
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

        <div class="main-content">
            <h1 class="mb-4">Load Transaction Report</h1>

            <!-- Year and Month Selection Form -->
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="year" class="form-label">Select Year</label>
                        <select name="year" id="year" class="form-select" required>
                            <?php
                            for ($i = 2020; $i <= date('Y'); $i++) {
                                $selected = ($i == $currentYear) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="month" class="form-label">Select Month</label>
                        <select name="month" id="month" class="form-select" required>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                $selected = ($i == $currentMonth) ? 'selected' : '';
                                echo "<option value='$i' $selected>" . date("F", mktime(0, 0, 0, $i, 1)) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="day" class="form-label">Select Day</label>
                        <input type="checkbox" id="include_day" name="include_day" <?php echo ($currentDay ? 'checked' : ''); ?>>
                        <label for="day" class="form-label">Include Day</label>
                        <select name="day" id="day" class="form-select" <?php echo (!$currentDay ? 'disabled' : ''); ?>>
                            <?php
                            if ($currentDay) {
                                for ($d = 1; $d <= date('t', strtotime("$currentYear-$currentMonth-01")); $d++) {
                                    $selected = ($d == $currentDay) ? 'selected' : '';
                                    echo "<option value='$d' $selected>$d</option>";
                                }
                            } else {
                                // Generate days for the selected month regardless of the checkbox state
                                for ($d = 1; $d <= date('t', strtotime("$currentYear-$currentMonth-01")); $d++) {
                                    echo "<option value='$d'>$d</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
            <!-- Chart Container -->
            <canvas id="revenueChart"></canvas>
            <!-- Display the Revenue -->
            <h2 class="mt-5">Revenue for
                <?php echo date("F", mktime(0, 0, 0, $currentMonth, 1)) . ' ' . $currentYear; ?>
            </h2>
            <h1>Total Revenue: ₱<?php echo number_format($selectedDayRevenue, 2); ?></h1>

            <a href="?generate_pdf=true" class="btn btn-danger">Download PDF</a>


        </div>
    </div>

    <script>
        function toggleSidebar(event) {
            event.preventDefault();
            $("#sidebar").toggleClass('active');
        }

        // Enable day selection if the checkbox is checked
        $('#include_day').change(function () {
            if ($(this).is(':checked')) {
                $('#day').prop('disabled', false);
            } else {
                $('#day').prop('disabled', true);
            }
        });

        // Chart.js configuration
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = <?php echo json_encode(array_values($dailyRevenue)); ?>; // Daily revenue data
        const labels = Array.from({ length: revenueData.length }, (_, i) => i + 1); // Create labels for days

        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Revenue',
                    data: revenueData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (₱)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Days'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>