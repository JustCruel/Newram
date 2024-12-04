<?php
session_start();
include '../config/connection.php';

// Initialize variables
$successMessage = '';
$errorMessage = '';

// Function to calculate distance between two GPS coordinates (in meters)
function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // Earth radius in meters

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c; // Distance in meters

    return $distance;
}

// Process the RFID tap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfidAccountNumber = $_POST['account_number']; // Get account number from RFID input
    $gpsLatitude = $_POST['gps_latitude']; // Get current latitude
    $gpsLongitude = $_POST['gps_longitude']; // Get current longitude

    // Fetch the user’s current balance using the account number
    $userQuery = "SELECT id, balance FROM useracc WHERE account_number = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $rfidAccountNumber); // Assuming account_number is a string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $userId = $user['id'];

        if ($user['balance'] < 10) {
            $_SESSION['errorMessage'] = 'Insufficient balance! You need at least ₱10 to start a trip.';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        // Check if the user has an ongoing journey
        $journeyQuery = "SELECT * FROM journeys WHERE user_id = ? AND is_completed = 0 LIMIT 1";
        $journeyStmt = $conn->prepare($journeyQuery);
        $journeyStmt->bind_param("i", $userId);
        $journeyStmt->execute();
        $journeyResult = $journeyStmt->get_result();
        $ongoingJourney = $journeyResult->fetch_assoc();

        if ($ongoingJourney) {
            // If an ongoing journey is found, this is the end of the journey
            $startLat = $ongoingJourney['start_latitude'];
            $startLon = $ongoingJourney['start_longitude'];
            $endLat = $gpsLatitude;
            $endLon = $gpsLongitude;

            // Calculate the distance between start and end points (in meters)
            $distance = calculateDistance($startLat, $startLon, $endLat, $endLon);

            // Convert distance from meters to kilometers
            $distanceKm = $distance / 1000;

            // Calculate fare
            if ($distanceKm <= 4) {
                $fareAmount = 12; // First 4km is ₱12
            } else {
                $additionalKm = $distanceKm - 4;
                $fareAmount = 12 + ($additionalKm * 2.4); // ₱12 for the first 4km + ₱4 per additional km
            }

            // Set a minimum fare of ₱12.00
            if ($fareAmount < 12.00) {
                $fareAmount = 12.00;
            }

            // Round up to the nearest cent
            $fareAmount = ceil($fareAmount * 100) / 100;

            if ($user['balance'] >= $fareAmount) {
                // Deduct the fare from user's balance
                $newBalance = $user['balance'] - $fareAmount;

                // Update the user's balance
                $updateBalanceQuery = "UPDATE useracc SET balance = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateBalanceQuery);
                $updateStmt->bind_param("di", $newBalance, $userId);
                $updateStmt->execute();

                // Update the journey with end coordinates, fare, and mark it as completed
                $updateJourneyQuery = "UPDATE journeys 
                SET end_latitude = ?, end_longitude = ?, end_time = NOW(), fare_amount = ?, is_completed = 1 
                WHERE id = ?";
                $updateStmt = $conn->prepare($updateJourneyQuery);
                $updateStmt->bind_param("dddi", $endLat, $endLon, $fareAmount, $ongoingJourney['id']);
                $updateStmt->execute();

                // Insert into revenue table
                $insertRevenueQuery = "INSERT INTO revenue (user_id, amount, transaction_type, transaction_date) VALUES (?, ?, 'debit', NOW())";
                $revenueStmt = $conn->prepare($insertRevenueQuery);
                $revenueStmt->bind_param("id", $userId, $fareAmount);
                $revenueStmt->execute();

                // Set success message
                $_SESSION['successMessage'] = 'Fare deducted successfully! Total fare: ₱' . number_format($fareAmount, 2);
            } else {
                // Insufficient balance
                $_SESSION['errorMessage'] = 'Insufficient balance for this trip. Please load more funds.';
            }
        } else {
            // No ongoing journey found, so start a new journey
            $insertJourneyQuery = "INSERT INTO journeys (user_id, start_latitude, start_longitude) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertJourneyQuery);
            $insertStmt->bind_param("idd", $userId, $gpsLatitude, $gpsLongitude);
            $insertStmt->execute();

            // Set success message for starting the journey
            $_SESSION['successMessage'] = 'Journey started. Tap again to end the trip.';
        }
    } else {
        // If user is not found, set error message
        $_SESSION['errorMessage'] = 'User not found!';
    }

    // Refresh the page after submission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Capture session messages and then clear them
$successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : '';
$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';
unset($_SESSION['successMessage']);
unset($_SESSION['errorMessage']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>RFID Bus Fare Management</h1>
        <form method="POST" action="" id="rfidForm">
            <div class="mb-3">
                <label for="account_number" class="form-label">RFID Account Number</label>
                <input type="text" class="form-control" id="account_number" name="account_number" required autofocus>
            </div>
            <input type="hidden" id="gps_latitude" name="gps_latitude">
            <input type="hidden" id="gps_longitude" name="gps_longitude">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        // Automatically get GPS coordinates and fill hidden fields
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Update hidden fields
                    document.getElementById('gps_latitude').value = latitude;
                    document.getElementById('gps_longitude').value = longitude;

                    // Log the current GPS coordinates to the console
                    console.log(`Current Location: Latitude: ${latitude}, Longitude: ${longitude}`);
                }, function (error) {
                    console.error("Error getting location: ", error);
                }, {
                    enableHighAccuracy: true,
                    maximumAge: 0,
                    timeout: 5000
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            getLocation(); // Get GPS coordinates on page load
            document.getElementById('account_number').focus(); // Auto-focus RFID input field
        });

        <?php if ($successMessage): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= $successMessage ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                document.getElementById('rfidForm').reset();
            });
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= $errorMessage ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                document.getElementById('rfidForm').reset();
            });
        <?php endif; ?>
    </script>
</body>

</html>