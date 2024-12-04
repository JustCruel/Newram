<?php
session_start();
include '../config/connection.php';
include 'sidebar.php'; // Ensure you include your database connection script

// Assuming the user is logged in and their session is active
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

// Variables for today
$today = date('Y-m-d');

// Query to get all bus numbers
$busQuery = "SELECT DISTINCT bus_number FROM passenger_logs";

if ($stmt = $conn->prepare($busQuery)) {
    $stmt->execute();
    $stmt->bind_result($busNumber);
    $buses = [];

    // Fetch all bus numbers
    while ($stmt->fetch()) {
        $buses[] = $busNumber;
    }
    $stmt->close();
} else {
    echo "<script>alert('Error preparing query for bus numbers');</script>";
}

// Fetch total fare and passenger count for each bus
$busData = [];

foreach ($buses as $bus) {
    // Query to get total fare for today for the bus
    $fareQuery = "SELECT SUM(fare) AS total_fare
                  FROM passenger_logs
                  WHERE bus_number = ? AND DATE(timestamp) = ?";

    if ($stmt = $conn->prepare($fareQuery)) {
        $stmt->bind_param("ss", $bus, $today);
        $stmt->execute();
        $stmt->bind_result($totalFare);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing query for total fare');</script>";
        continue;
    }

    // Query to get the number of passengers who boarded the bus today
    $passengerQuery = "SELECT COUNT(*) AS passenger_count
                       FROM passenger_logs
                       WHERE bus_number = ? AND DATE(timestamp) = ?";

    if ($stmt = $conn->prepare($passengerQuery)) {
        $stmt->bind_param("ss", $bus, $today);
        $stmt->execute();
        $stmt->bind_result($passengerCount);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing query for passenger count');</script>";
        continue;
    }

    // Store the data for each bus
    $busData[] = [
        'bus_number' => $bus,
        'total_fare' => $totalFare,
        'passenger_count' => $passengerCount
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare and Passengers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        h2 {
            color: black;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Bus Fare and Passengers Report for Today</h2>

        <!-- Display the bus data -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Bus Number</th>
                    <th>Total Fare Collected Today</th>
                    <th>Number of Passengers</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($busData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['bus_number']); ?></td>
                        <td>₱<?php echo number_format($data['total_fare'], 2); ?></td>
                        <td><?php echo $data['passenger_count']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>

</html>