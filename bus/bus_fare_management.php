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

    // Validate account number
    if (!preg_match('/^[a-zA-Z0-9]+$/', $rfidAccountNumber)) {
        $_SESSION['errorMessage'] = 'Invalid account number format.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Fetch the user’s current balance using the account number
    $userQuery = "SELECT id, balance FROM useracc WHERE account_number = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $rfidAccountNumber); // Assuming account_number is a string
    if (!$stmt->execute()) {
        $_SESSION['errorMessage'] = 'Database error: ' . $stmt->error;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $userId = $user['id'];

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
            $farePerMeter = 0.5; // 0.5 cents per meter
            $fareAmount = $distance * $farePerMeter;

            // Set a minimum fare of ₱1.00
            if ($fareAmount < 1.00) {
                $fareAmount = 1.00;
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
            // Check minimum balance before starting a journey
            if ($user['balance'] >= 0.5) { // Minimum balance to start a journey
                // Start a new journey
                $insertJourneyQuery = "INSERT INTO journeys (user_id, start_latitude, start_longitude, start_time) VALUES (?, ?, ?, NOW())";
                $insertStmt = $conn->prepare($insertJourneyQuery);
                $insertStmt->bind_param("idd", $userId, $gpsLatitude, $gpsLongitude);
                $insertStmt->execute();

                $_SESSION['successMessage'] = 'Journey started. Tap again to end the journey.';
            } else {
                $_SESSION['errorMessage'] = 'Insufficient balance to start a journey.';
            }
        }
    } else {
        $_SESSION['errorMessage'] = 'Account number not found.';
    }

    // Redirect back to the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>