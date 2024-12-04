<?php
session_start();
include 'config/connection.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginadmin.php");
    exit;
}
include 'sidebaradmin.php';

// Initialize variables for the current year, month, and day
$currentYear = date('Y');
$currentMonth = date('m');
$currentDay = date('d'); // Get current day

// Handle form submission for year, month, and day selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['year']) && isset($_POST['month'])) {
    $currentYear = mysqli_real_escape_string($conn, $_POST['year']);
    $currentMonth = mysqli_real_escape_string($conn, $_POST['month']);
    $includeDay = isset($_POST['include_day']) ? true : false; // Check if day should be included

    // If day is included, get the selected day
    if ($includeDay && isset($_POST['day'])) {
        $currentDay = mysqli_real_escape_string($conn, $_POST['day']);
    } else {
        $currentDay = null; // Set to null if day is not included
    }
}

// Fetch daily revenue data for the selected year and month
$dailyRevenueQuery = "SELECT DAY(transaction_date) AS day, SUM(amount) AS total_revenue 
                      FROM revenue 
                      WHERE YEAR(transaction_date) = '$currentYear' 
                      AND MONTH(transaction_date) = '$currentMonth' 
                      AND transaction_type = 'debit'  -- Assuming debit means fare deducted
                      GROUP BY DAY(transaction_date)";
$dailyRevenueResult = mysqli_query($conn, $dailyRevenueQuery);

// Check for query errors
if (!$dailyRevenueResult) {
    die("Database query failed: " . mysqli_error($conn));
}

// Initialize an array to hold the daily revenues
$dailyRevenue = array_fill(1, date('t', strtotime("$currentYear-$currentMonth-01")), 0);

// Populate the array with data from the query result
while ($row = mysqli_fetch_assoc($dailyRevenueResult)) {
    $dailyRevenue[$row['day']] = $row['total_revenue'];
}

// Fetch revenue for the selected day
$selectedDayRevenue = $currentDay !== null && isset($dailyRevenue[$currentDay]) ? $dailyRevenue[$currentDay] : 0;

// Function to generate PDF
if (isset($_GET['generate_pdf'])) {
    require('fpdf/fpdf.php'); // Adjust the path to the fpdf.php file

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

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
    </style>
</head>

<body>

    <div class="main-content">
        <h1 class="mb-4">Revenue Report</h1>

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
                        for ($m = 1; $m <= 12; $m++) {
                            $selected = ($m == $currentMonth) ? 'selected' : '';
                            echo "<option value='$m' $selected>" . date("F", mktime(0, 0, 0, $m, 1)) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="include_day" id="include_day" class="form-check-input" <?php echo isset($_POST['include_day']) ? 'checked' : ''; ?>>
                        <label for="include_day" class="form-check-label">Include Day</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3" id="daySelection"
                style="display: <?php echo isset($_POST['include_day']) ? 'block' : 'none'; ?>;">
                <div class="col-md-4">
                    <label for="day" class="form-label">Select Day</label>
                    <select name="day" id="day" class="form-select">
                        <?php
                        // Generate days based on the selected month and year
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                        for ($d = 1; $d <= $daysInMonth; $d++) {
                            $selected = ($d == $currentDay) ? 'selected' : '';
                            echo "<option value='$d' $selected>$d</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" class="btn btn-danger" id="generatePdfBtn">Download PDF</button>
        </form>

        <!-- Display the revenue for the selected day or month -->
        <div class="mt-4">
            <h3>Total Revenue</h3>
            <p>For
                <?php echo $currentDay !== null ? "Day $currentDay: " : ''; ?>₱<?php echo number_format($selectedDayRevenue, 2); ?>
            </p>
        </div>

        <!-- Chart for daily revenue -->
        <canvas id="revenueChart" width="400" height="200"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const dailyRevenue = <?php echo json_encode($dailyRevenue); ?>;
            const labels = Object.keys(dailyRevenue).map(day => day);
            const data = Object.values(dailyRevenue);

            const revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Revenue',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
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
                        }
                    }
                }
            });

            document.getElementById('generatePdfBtn').addEventListener('click', function () {
                const url = new URL(window.location.href);
                url.searchParams.set('generate_pdf', 'true');
                if (document.getElementById('include_day').checked) {
                    url.searchParams.set('day', document.getElementById('day').value);
                }
                window.open(url, '_blank');
            });
        </script>
    </div>

</body>

</html>