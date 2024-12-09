<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$host = 'localhost';
$dbname = 'ramstardb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Check for a POST request with RFID ID
// Check for a POST request with RFID ID
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rfid_id'])) {
    $rfidId = $_POST['rfid_id'];
    $action = $_POST['action'] ?? '';  // Default to empty if action isn't provided

    // Simulate checking for an active trip (you should replace this with your actual logic)
    if ($action == 'check_status') {
        // Query to check if the user has an active trip (tap in without tap out)
        $sql = "SELECT * FROM tap_in_out WHERE rfid_id = :rfidId AND tap_out_time IS NULL ORDER BY tap_in_time DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['rfidId' => $rfidId]);
        $activeTrip = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'message' => 'RFID scanned successfully',
            'rfid_id' => $rfidId,
            'active_trip' => $activeTrip ? true : false, // Check if the user has an active trip
            'start_stop' => $activeTrip ? $activeTrip['start_stop'] : null // Return the start stop for tap out
        ]);
    } elseif ($action == 'tap_in' || $action == 'tap_out') {
        $startStop = $_POST['start_stop'] ?? '';
        $endStop = $_POST['end_stop'] ?? '';

        if ($action == 'tap_in') {
            // Insert Tap In record
            $sql = "INSERT INTO tap_in_out (rfid_id, start_stop) VALUES (:rfidId, :startStop)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['rfidId' => $rfidId, 'startStop' => $startStop]);
            echo json_encode([
                'status' => 'success',
                'message' => 'Tap In successful'
            ]);
        } else {
            // Handle Tap Out and calculate fare
            $distances = [
                'Zaragoza' => ['Santa Rosa' => 15, 'Cabanatuan Terminal' => 25],
                'Santa Rosa' => ['Zaragoza' => 15, 'Cabanatuan Terminal' => 10],
                'Cabanatuan Terminal' => ['Zaragoza' => 25, 'Santa Rosa' => 10],
            ];

            if (isset($distances[$startStop][$endStop])) {
                $distance = $distances[$startStop][$endStop];
                $fare = calculateFare($distance); // Calculate fare based on distance

                // Get user's current balance
                $sql = "SELECT balance FROM useracc WHERE account_number = :rfidId";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['rfidId' => $rfidId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $currentBalance = $user['balance'];

                    // Check if user has enough balance
                    if ($currentBalance >= $fare) {
                        // Deduct the fare from the balance
                        $newBalance = $currentBalance - $fare;

                        // Update Tap Out record
                        $sql = "UPDATE tap_in_out SET end_stop = :endStop, fare = :fare, tap_out_time = CURRENT_TIMESTAMP WHERE rfid_id = :rfidId AND tap_out_time IS NULL";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['endStop' => $endStop, 'fare' => $fare, 'rfidId' => $rfidId]);

                        // Update the user's balance
                        $sql = "UPDATE useracc SET balance = :newBalance WHERE account_number = :rfidId";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['newBalance' => $newBalance, 'rfidId' => $rfidId]);

                        // Respond with the transaction details and new balance
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Tap Out successful',
                            'fare' => $fare,
                            'new_balance' => $newBalance,
                            'start_stop' => $startStop,
                            'end_stop' => $endStop,
                            'transaction_time' => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Insufficient balance'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'User not found'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid route'
                ]);
            }
        }
    } else {
        // If action is not recognized, return an error
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid action'
        ]);
    }
    exit;
}


// Fare calculation function
function calculateFare($distance)
{
    $baseFare = 14; // First 4 km
    $additionalFare = 2; // Additional fare per km

    if ($distance <= 4) {
        return $baseFare;
    } else {
        return $baseFare + (($distance - 4) * $additionalFare);
    }
}

// If not a POST request, return an error message
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request'
]);
exit;
?>