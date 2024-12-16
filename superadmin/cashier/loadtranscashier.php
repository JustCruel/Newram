<?php
session_start();
include '../config/connection.php';

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['email']) || !in_array($_SESSION['role'], ['Cashier', 'Superadmin'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch user data
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];


// Fetch user details from the database
$query = "SELECT firstname, lastname FROM useracc WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
$stmt->fetch();
$stmt->close();

// Initialize variables for the current date
$currentDate = new DateTime();
$currentYear = $currentDate->format('Y');
$currentMonth = $currentDate->format('m');
$currentDay = $currentDate->format('d');
$dailyRevenue = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected date
    $selectedDate = mysqli_real_escape_string($conn, $_POST['date']);
    $currentDate = new DateTime($selectedDate);
    $currentYear = $currentDate->format('Y');
    $currentMonth = $currentDate->format('m');
    $currentDay = $currentDate->format('d');

    // Fetch daily revenue data for the selected date
    $dailyRevenueQuery = "SELECT DAY(transaction_date) AS day, SUM(amount) AS total_revenue 
                          FROM transactions 
                          WHERE DATE(transaction_date) = ? 
                          AND transaction_type = 'Load'
                          GROUP BY DAY(transaction_date)";
    $stmt = $conn->prepare($dailyRevenueQuery);
    $stmt->bind_param('s', $selectedDate);
    $stmt->execute();
    $dailyRevenueResult = $stmt->get_result();

    if (!$dailyRevenueResult) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $dailyRevenue = array_fill(1, $currentDate->format('t'), 0);

    while ($row = $dailyRevenueResult->fetch_assoc()) {
        $dailyRevenue[$row['day']] = $row['total_revenue'];
    }

    // Calculate selected day revenue
    $selectedDayRevenue = $dailyRevenue[$currentDay] ?? 0;
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
    <link rel="stylesheet" href=" https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
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

    <h1 class="mb-4">Load Transaction Report</h1>

    <!-- Year and Month Selection Form -->
    <form method="POST" action="">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="date" class="form-label">Select Date</label>
                <input type="date" id="date" name="date" class="form-control"
                    value="<?php echo $currentYear . '-' . $currentMonth . '-' . $currentDay; ?>" <?php echo (!$currentDay ? 'disabled' : ''); ?>>
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

    <script src="../js/main.js"></script>
    <script>
        $(document).ready(function () {
            $('#date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function (e) {
                // Enable the form submission when a date is selected
                $(this).closest('form').submit();
            });
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