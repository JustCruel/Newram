<?php
session_start();
include '../config/connection.php'; // Include your DB connection here

// Database connection
$host = 'localhost';
$dbname = 'ramstardb';
$username = 'root';
$password = '';
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$conductorName = $firstname . ' ' . $lastname;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Fetch user data using PDO
$user_id = $_SESSION['account_number'] ?? null;
if (!$user_id) {
    die(json_encode(['status' => 'error', 'message' => 'Account number missing from session.']));
}

$query = "SELECT firstname, lastname FROM useracc WHERE account_number = :account_number";
$stmt = $pdo->prepare($query);
$stmt->execute(['account_number' => $user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    die(json_encode(['status' => 'error', 'message' => 'User not found.']));
}

// Fetch routes (from the fare_routes table)
$queryRoutes = "SELECT route_name, province, regular_fare, discounted_fare, special_fare, post FROM fare_routes"; // Added 'post' field
$stmtRoutes = $pdo->prepare($queryRoutes);
$stmtRoutes->execute();
$routes = $stmtRoutes->fetchAll(PDO::FETCH_ASSOC);

// Fetch unique locations for dropdown (start and end points)
$uniqueLocations = [];
foreach ($routes as $route) {
    $uniqueLocations[] = $route['route_name']; // Assuming 'route_name' is your unique location
}

// Fare calculation function with passenger type and quantity

// Adjusted fare calculation function with distance-based fare calculation
function calculateFare($startStop, $endStop, $passengerType, $quantity, $routes)
{
    $fare = 0;
    $startDistance = 0;
    $endDistance = 0;

    // Find the start and end distance based on the route
    foreach ($routes as $route) {
        if ($route['route_name'] == $startStop) {
            $startDistance = isset($route['post']) ? $route['post'] : 0; // Check for 'post' key
        }
        if ($route['route_name'] == $endStop) {
            $endDistance = isset($route['post']) ? $route['post'] : 0; // Check for 'post' key
        }
    }

    if ($startDistance == 0 || $endDistance == 0) {
        return json_encode(['status' => 'error', 'message' => 'Invalid route(s).']);
    }

    // Calculate the distance traveled
    $distanceTraveled = abs($endDistance - $startDistance); // Absolute value to avoid negative distances

    // Base fare calculation
    $baseFare = 14; // Base fare for the first 4 km
    $additionalFarePerKm = 2; // Additional fare for every km beyond the first 4 km

    if ($distanceTraveled <= 4) {
        $fare = $baseFare; // If within 4 km, use base fare
    } else {
        // If over 4 km, base fare plus additional fare
        $additionalDistance = $distanceTraveled - 4;
        $fare = $baseFare + ($additionalFarePerKm * $additionalDistance);
    }

    // Apply passenger type discounts
    switch ($passengerType) {
        case 'student':
        case 'senior':
        case 'pwd':
        case 'pregnant':
            $fare = $fare * 0.8; // 20% discount for special passengers
            break;
        default:
            // Regular passenger, no discount
            break;
    }

    $fare *= $quantity; // Multiply by the number of passengers

    return $fare;
}


// Process payment
function processPayment($pdo, $rfidId, $fare)
{
    $queryBalance = "SELECT balance FROM useracc WHERE account_number = :rfid_id";
    $stmtBalance = $pdo->prepare($queryBalance);
    $stmtBalance->execute(['rfid_id' => $rfidId]);
    $user = $stmtBalance->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return json_encode(['status' => 'error', 'message' => 'RFID ID not found.']);
    }

    $userBalance = $user['balance'];
    if ($userBalance < $fare) {
        return json_encode(['status' => 'error', 'message' => 'Insufficient balance.']);
    }

    $newBalance = $userBalance - $fare;
    $queryUpdate = "UPDATE useracc SET balance = :new_balance WHERE account_number = :rfid_id";
    $stmtUpdate = $pdo->prepare($queryUpdate);
    $stmtUpdate->execute(['new_balance' => $newBalance, 'rfid_id' => $rfidId]);

    return json_encode(['status' => 'success', 'message' => 'Payment successful!', 'new_balance' => $newBalance]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (!isset($_POST['rfid_id'], $_POST['start_stop'], $_POST['end_stop'], $_POST['passenger_type'], $_POST['quantity'])) {
            throw new Exception('Required parameters missing.');
        }

        $rfidId = filter_var($_POST['rfid_id'], FILTER_SANITIZE_STRING);
        $startStop = filter_var($_POST['start_stop'], FILTER_SANITIZE_STRING);
        $endStop = filter_var($_POST['end_stop'], FILTER_SANITIZE_STRING);
        $passengerType = filter_var($_POST['passenger_type'], FILTER_SANITIZE_STRING);
        $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);

        if ($quantity === false) {
            throw new Exception('Invalid quantity value.');
        }

        // Calculate fare
        $fare = calculateFare($startStop, $endStop, $passengerType, $quantity, $routes);

        if (is_numeric($fare)) {
            // Process the payment
            echo processPayment($pdo, $rfidId, $fare);
        } else {
            echo $fare; // Error message from fare calculation
        }

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare Management System</title>
    <!-- Include Bootstrap and jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Bus Fare Management</h1>

        <!-- RFID Input -->
       

        <div class="mb-4">
            <label for="start-stop" class="form-label">From:</label>
            <select id="start-stop" class="form-select">
                <?php foreach ($uniqueLocations as $location) {
                    echo "<option value='" . htmlspecialchars($location) . "'>" . htmlspecialchars($location) . "</option>";
                } ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="end-stop" class="form-label">To:</label>
            <select id="end-stop" class="form-select">
                <?php foreach ($uniqueLocations as $location) {
                    echo "<option value='" . htmlspecialchars($location) . "'>" . htmlspecialchars($location) . "</option>";
                } ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="passenger-type" class="form-label">Passenger Type:</label>
            <select id="passenger-type" class="form-select">
                <option value="regular">Regular</option>
                <option value="student">Student</option>
                <option value="senior">Senior Citizen</option>
                <option value="pwd">PWD</option>
                <option value="pregnant">Pregnant</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="number" id="quantity" class="form-control" value="1" min="1" />
        </div>
        <div class="mb-4">
            <label for="rfid-input" class="form-label">Scan RFID:</label>
            <input type="text" id="rfid-input" class="form-control" placeholder="Scan RFID" autofocus />
        </div>
        <button id="calculate-btn" class="btn btn-primary w-100">Calculate and Pay</button>
    </div>

    <script>
        $(document).ready(function () {
            $('#rfid-input').on('input', function () {
                const rfid = $(this).val().trim();

                if (rfid) {
                    // Get values from the form
                    const startStop = $('#start-stop').val();
                    const endStop = $('#end-stop').val();
                    const passengerType = $('#passenger-type').val();
                    const quantity = $('#quantity').val();

                    // Send data via AJAX
                    $.ajax({
                        url: 'process_payment.php', // Your PHP file to process the payment
                        type: 'POST',
                        data: {
                            rfid_id: rfid,
                            start_stop: startStop,
                            end_stop: endStop,
                            passenger_type: passengerType,
                            quantity: quantity
                        },
                        success: function (response) {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successful',
                                    text: `New Balance: ${res.new_balance}`,
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Payment Failed',
                                    text: res.message,
                                    confirmButtonText: 'Try Again'
                                });
                            }

                            // Clear the RFID input after processing
                            $('#rfid-input').val('');
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });

            $('#calculate-btn').on('click', function () {
                $('#rfid-input').focus();
            });
        });
    </script>
</body>

</html>
