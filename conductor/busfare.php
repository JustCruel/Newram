<?php

include '../config/connection.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Conductor' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$bus_number = isset($_SESSION['bus_number']) ? $_SESSION['bus_number'] : 'Unknown Bus Number';
$conductorac = isset($_SESSION['driver_account_number']) ? $_SESSION['driver_account_number'] : 'unknown conductor account number';
$driverName = isset($_SESSION['driver_name']) ? $_SESSION['driver_name'] : 'unknown driver name';
$conductorName = isset($_SESSION['conductor_name']) ? $_SESSION['conductor_name'] : 'unknown conductor name';

$conductorName = $firstname . ' ' . $lastname;

// Fetch routes
$routes = [];
$query = "SELECT * FROM fare_routes";
$result = $conn->query($query);
$balance = 0;

while ($row = $result->fetch_assoc()) {
    $routes[] = $row;
}

// Fetch base fare and additional fare from fare_settings table
$fareSettingsQuery = "SELECT * FROM fare_settings LIMIT 1"; // Assuming there's only one record
$fareSettingsResult = $conn->query($fareSettingsQuery);
$fareSettings = $fareSettingsResult->fetch_assoc();

// Store passengers in a session to track those currently on the bus
if (!isset($_SESSION['passengers'])) {
    $_SESSION['passengers'] = [];
}

// Function to fetch balance based on RFID
// Function to log passenger entry
function logPassengerEntry($rfid, $fromRoute, $toRoute, $fare, $conductorName, $busNumber, $transactionNumber, $conn)
{
    $query = "INSERT INTO passenger_logs (rfid, from_route, to_route, fare, conductor_name, bus_number, transaction_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $rfid, $fromRoute, $toRoute, $fare, $conductorName, $busNumber, $transactionNumber);
    $stmt->execute();
    $stmt->close();
}
function getUserBalance($rfid, $conn)
{
    $query = "SELECT balance FROM useracc WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $rfid);
    $stmt->execute();
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();
    return $balance;
}

// Function to deduct fare from user's balance
function deductFare($rfid, $fare, $conn)
{
    $query = "UPDATE useracc SET balance = balance - ? WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ds", $fare, $rfid);
    $stmt->execute();
    $stmt->close();
}

// Handle the POST request to get the user balance and update balance after fare deduction
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['fromRoute'], $data['toRoute'], $data['fareType'], $data['passengerQuantity'])) {
        $rfid = isset($data['rfid']) ? $data['rfid'] : ''; // RFID is optional for cash payments
        $fromRoute = $data['fromRoute'];
        $toRoute = $data['toRoute'];
        $fareType = $data['fareType'];
        $passengerQuantity = $data['passengerQuantity'];
        $transactionNumber = $data['transactionNumber'];

        // Fetch balance for RFID if not a cash payment
        if (!empty($rfid)) {
            $balance = getUserBalance($rfid, $conn);
            if ($balance === false) {
                echo json_encode(['status' => 'error', 'message' => 'RFID not found or invalid.']);
                exit;
            }
        } else {
            $balance = 0; // No balance check for cash payment
        }

        // Calculate distance
        $distance = abs($fromRoute['post'] - $toRoute['post']);
        $_SESSION['distance'] = $distance;
        $fare = $fareSettings['base_fare']; // Default fare for first 4 km
        if ($distance > 4) {
            $fare += ($distance - 4) * $fareSettings['additional_fare'];
        }

        // Apply discount if applicable
        if ($fareType === 'discounted') {
            $fare *= 0.8; // 20% discount
        }

        // Calculate total fare with passenger quantity
        $totalFare = $fare * $passengerQuantity;

        // If RFID and balance are sufficient, deduct the fare
        if (empty($rfid) || $balance >= $totalFare) {
            if (!empty($rfid)) {
                deductFare($rfid, $totalFare, $conn);
            }

            // Track the passenger
// Track the passenger
            $_SESSION['passengers'][] = [
                'rfid' => $rfid,
                'fromRoute' => $fromRoute,
                'toRoute' => $toRoute,
                'fare' => $totalFare,
                'status' => 'onBoard',
            ];

            $loggedRfid = !empty($rfid) ? $rfid : 'cash'; // Use 'cash' if payment is made in cash
            logPassengerEntry($loggedRfid, $fromRoute['route_name'], $toRoute['route_name'], $totalFare, $conductorName, $bus_number, $transactionNumber, $conn);

            echo json_encode([
                'status' => 'success',
                'message' => 'Fare deducted successfully.',
                'new_balance' => $balance - $totalFare,
                'fare' => $totalFare,
                'distance' => $distance
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Insufficient balance. Please load your account.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required data.']);
    }
    exit;
}


// Driver dashboard functionality (for fetching passengers and their destinations)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dashboard'])) {
    // Fetch passengers currently on board
    $passengers = $_SESSION['passengers'];

    // Group passengers by destination and count them
    $destinationCount = [];

    foreach ($passengers as $passenger) {
        $destination = $passenger['toRoute']['route_name'];

        // Initialize the destination count if not already set
        if (!isset($destinationCount[$destination])) {
            $destinationCount[$destination] = 0;
        }

        // Check if this passenger has already been counted (if already exists, subtract 1)
        if (isset($passenger['getOff']) && $passenger['getOff'] === true) {
            $destinationCount[$destination]--; // Remove one passenger
        } else {
            $destinationCount[$destination]++; // Add one passenger
        }

        // Ensure the count doesn't go negative
        if ($destinationCount[$destination] < 0) {
            $destinationCount[$destination] = 0; // Reset to zero if negative
        }
    }

    // Return the grouped data to the driver
    echo json_encode([
        'status' => 'success',
        'destination_count' => $destinationCount
    ]);
    exit;
}

// Handle passenger removal (for when they get off)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['removePassenger'])) {
    $destination = $_GET['destination'];

    // Logic to find and update the passenger's 'getOff' status
    $passengers = &$_SESSION['passengers'];

    foreach ($passengers as &$passenger) {
        if ($passenger['toRoute']['route_name'] === $destination && !isset($passenger['getOff'])) {
            $passenger['getOff'] = true; // Mark the passenger as gotten off
            break;
        }
    }

    echo json_encode(['status' => 'success']);
    exit;
}
$query = "SELECT base_fare, additional_fare FROM fare_settings WHERE id = 1"; // Change the WHERE clause as needed
$result = $conn->query($query);

// Check if the query returned a result
if ($result->num_rows > 0) {
    // Fetch the base_fare and additional_fare
    $row = $result->fetch_assoc();
    $base_fare = $row['base_fare'];
    $additional_fare = $row['additional_fare'];
} else {
    // Default values in case the query fails or no results
    $base_fare = 14;
    $additional_fare = 2;
}
// Close connection after all operations are done
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 8px;
        }

        .form-label {
            font-weight: 600;
        }

        #calculateFare {
            width: 100%;
        }
    </style>
</head>

<body>

    <?php
    include '../sidebar.php'
        ?>
    <div class="container mt-5">
        <h1 class="text-center text-primary">Bus Fare Calculator</h1>
        <form id="fareForm" class="mt-4">
            <!-- KM Display -->
            <div class="d-flex justify-content-center align-items-center mb-4" style="min-height: 120px;">
                <div class="card shadow-sm text-center p-3">
                    <h5 class="form-label mb-2" style="color: #007BFF;">Distance (KM)</h5>
                    <span id="kmLabel" class="h4 text-primary font-weight-bold">0 km</span>
                </div>
                <div class="card shadow-sm text-center p-3">
                    <h5 class="form-label mb-2" style="color: #007BFF;">Total Fare (₱)</h5>
                    <span id="fareLabel" class="h4 text-success font-weight-bold">₱0.00</span>
                </div>
            </div>

            <!-- Route Selection -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fromRoute" class="form-label">From</label>
                    <select id="fromRoute" name="fromRoute" class="form-select">
                        <option value="" disabled selected>Select Starting Point</option>
                        <?php foreach ($routes as $route): ?>
                            <option value="<?= htmlspecialchars(json_encode($route), ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars($route['route_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="toRoute" class="form-label">To</label>
                    <select id="toRoute" name="toRoute" class="form-select">
                        <option value="" disabled selected>Select Destination</option>
                        <?php foreach ($routes as $route): ?>
                            <option value="<?= htmlspecialchars(json_encode($route), ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars($route['route_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Fare Type and Passenger Quantity -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fareType" class="form-label">Fare Type</label>
                    <select id="fareType" name="fareType" class="form-select">
                        <option value="regular">Regular</option>
                        <option value="discounted">Student/Senior (20% Off)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="passengerQuantity" class="form-label">Number of Passengers</label>
                    <input type="number" id="passengerQuantity" name="passengerQuantity" class="form-control" value="1"
                        min="1" max="10">
                </div>
            </div>

            <!-- RFID Scan Input 
            <div class="row mb-3">
                <div class="col-md-6 offset-md-3">
                    <label for="rfidInput" class="form-label">Scan RFID</label>
                    <input type="text" id="rfidInput" name="rfidInput" class="form-control"
                        placeholder="Scan your RFID here">
                </div>
            </div>
             Calculate Button 
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <button type="button" id="calculateFare" class="btn btn-primary btn-lg shadow-sm">Calculate
                        Fare</button>
                </div>
            </div> -->
        </form>
        <!-- Fare Result -->
        <div id="fareResult" class="mt-4 alert alert-info d-none text-center">
            <strong>Your fare is calculated here.</strong>
        </div>

        <div class="modal fade" id="passengerModal" tabindex="-1" aria-labelledby="passengerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passengerModalLabel">Passenger Destinations</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="destinationTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>Number of Passengers</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Destination rows will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mb-4" style="min-height: 120px;">
            <!-- Card for Distance -->
            <div class="card shadow-sm text-center p-3 mx-2">
                <h5 class="form-label mb-2" style="color: #007BFF;">Payment</h5>
                <button class="btn btn-primary mt-3" onclick="processPayment('cash')">Cash</button>
            </div>

            <!-- RFID Payment Button -->
            <div class="card shadow-sm text-center p-3 mx-2">
                <h5 class="form-label mb-2" style="color: #007BFF;">Payment</h5>
                <button class="btn btn-success mt-3" onclick="promptRFIDInput()">RFID</button>
            </div>
        </div>

        <div class="col-md-6 offset-md-3"></div>
        <div class="card shadow-sm text-center p-3 mx-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#passengerModal">View
                Passengers</button>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        const baseFare = <?php echo $base_fare; ?>;
        const additionalFare = <?php echo $additional_fare; ?>;
        const driverName = "<?= $_SESSION['driver_name']; ?>";  // PHP variable for driver name

        document.getElementById('fromRoute').addEventListener('change', updateDistance);
        document.getElementById('toRoute').addEventListener('change', updateDistance);

        function updateDistance() {
            const fromRouteValue = document.getElementById('fromRoute').value;
            const toRouteValue = document.getElementById('toRoute').value;
            const kmLabel = document.getElementById('kmLabel');
            const fareLabel = document.getElementById('fareLabel');

            if (fromRouteValue && toRouteValue) {
                try {
                    const fromRoute = JSON.parse(fromRouteValue);
                    const toRoute = JSON.parse(toRouteValue);

                    // Calculate the distance in kilometers
                    const distance = Math.abs(fromRoute.post - toRoute.post);
                    kmLabel.textContent = `${distance} km`;
                    console.log(distance);

                    // Calculate the fare based on the distance
                    let totalFare = baseFare; // Start with the base fare for the first 4 km
                    if (distance > 4) {
                        // Add additional fare for kilometers beyond the first 4 km
                        totalFare += (distance - 4) * additionalFare;
                    }

                    fareLabel.textContent = `₱${totalFare.toFixed(2)}`;
                } catch (error) {
                    console.error('Error parsing route data:', error);
                    kmLabel.textContent = "Invalid route data";
                    fareLabel.textContent = "₱0.00";
                }
            } else {
                kmLabel.textContent = "0 km";
                fareLabel.textContent = "₱0.00";
            }
        }


        function validateRoutes() {
            const fromRoute = document.getElementById('fromRoute').value;
            const toRoute = document.getElementById('toRoute').value;

            if (!fromRoute || !toRoute) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Selection',
                    text: 'Please select both a starting point and a destination.',
                });
                return false;
            }
            return true;
        }

        async function fetchDashboardData() {
            try {
                const response = await fetch('<?= $_SERVER['PHP_SELF']; ?>?dashboard=true', {
                    method: 'GET',
                });

                const data = await response.json();
                if (data.status === 'success') {
                    updateDashboard(data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to fetch destination data.',
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Try again.',
                });
            }
        }

        function updateDashboard(data) {
            const tableBody = document.querySelector("#destinationTable tbody");
            tableBody.innerHTML = ''; // Clear existing rows

            // Iterate through the destinations and passenger count
            for (const [destination, count] of Object.entries(data.destination_count)) {
                if (count > 0) {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                    <td>${destination}</td>
                    <td>${count}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="removePassenger('${destination}')">-</button>
                    </td>
                `;
                    tableBody.appendChild(row);
                }
            }
        }

        async function removePassenger(destination) {
            const confirmation = await Swal.fire({
                title: 'Are you sure?',
                text: `You are about to remove a passenger going to ${destination}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove',
                cancelButtonText: 'Cancel'
            });

            if (confirmation.isConfirmed) {
                const response = await fetch('<?= $_SERVER['PHP_SELF']; ?>?removePassenger=true&destination=' + destination, {
                    method: 'GET',
                });

                const data = await response.json();
                if (data.status === 'success') {
                    fetchDashboardData(); // Refresh the passenger list
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to remove passenger.',
                    });
                }
            }
        }

        // Automatically fetch data when modal is opened
        $('#passengerModal').on('shown.bs.modal', function () {
            fetchDashboardData();
        });

        function generateTransactionNumber() {
            const timestamp = Date.now();
            const randomNum = Math.floor(Math.random() * (9999 - 1000 + 1)) + 1000;
            return `${timestamp}${randomNum}`;
        }

        function promptRFIDInput() {
            const fromRouteValue = document.getElementById('fromRoute').value;
            const toRouteValue = document.getElementById('toRoute').value;
            // Generate the transaction number before opening the Swal prompt
            const distance = Math.abs(fromRoute.post - toRoute.post);
            const transactionNumber = generateTransactionNumber();
            const paymentMethod = 'RFID';
            console.log("Generated Transaction Number:", transactionNumber); // Debugging line
            console.log("Generated Transaction Number:", distance); // Debugging line
            console.log("Generated Transaction Number:", paymentMethod);
            if (!validateRoutes()) {
                // Stop execution if routes are not selected
                return;
            }

            Swal.fire({
                title: 'Enter RFID',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                inputPlaceholder: 'Scan your RFID here',
                didOpen: () => {
                    const inputField = Swal.getInput();
                    inputField.addEventListener('input', async () => {
                        const rfid = inputField.value.trim();
                        if (rfid) {
                            // If RFID is entered, automatically process the fare
                            const fromRoute = JSON.parse(document.getElementById('fromRoute').value);
                            const toRoute = JSON.parse(document.getElementById('toRoute').value);
                            const fareType = document.getElementById('fareType').value;
                            const passengerQuantity = parseInt(document.getElementById('passengerQuantity').value, 10);
                            const paymentMethod = 'RFID';
                            if (!fromRoute || !toRoute) {
                                Swal.fire('Error', 'Please select both starting point and destination.', 'error');
                                return;
                            }

                            console.log("Transaction Number before calling getUserBalance:", transactionNumber); // Debugging line

                            // Call the function to get user balance and process the fare

                            getUserBalance(rfid, fromRoute, toRoute, fareType, passengerQuantity, true, transactionNumber, distance, paymentMethod);
                        }
                    });
                }
            });
        }



        // Function to get user balance based on RFID (account_number)
        function processPayment(paymentType) {
            if (!validateRoutes()) {
                return;
            }
            if (paymentType === 'cash') {
                Swal.fire({
                    title: 'Confirm Cash Payment',
                    text: 'Are you sure you want to pay in cash?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Proceed',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const rfid = '';
                        const fromRoute = JSON.parse(document.getElementById('fromRoute').value);
                        const toRoute = JSON.parse(document.getElementById('toRoute').value);
                        const fareType = document.getElementById('fareType').value;
                        const passengerQuantity = parseInt(document.getElementById('passengerQuantity').value, 10);
                        const paymentMethod = 'Cash';

                        // Generate transaction number
                        const transactionNumber = generateTransactionNumber();
                        const distance = Math.abs(fromRoute.post - toRoute.post);
                        getUserBalance(rfid, fromRoute, toRoute, fareType, passengerQuantity, true, transactionNumber, distance, paymentMethod);
                    }
                });
            }
        }

        // Updated getUserBalance function to handle both RFID and cash payments
        async function getUserBalance(rfid, fromRoute, toRoute, fareType, passengerQuantity, isCashPayment = false, transactionNumber, distance, paymentMethod) {
            const conductorName = "<?= $conductorName; ?>";  // PHP variable
            try {
                const baseFare = <?php echo $base_fare; ?>;
                const distance = Math.abs(fromRoute.post - toRoute.post);
                let totalFare = 0;

                // Calculate distance

                console.log("rfid:", rfid);
                console.log("fromRoute:", fromRoute);
                console.log("toRoute:", toRoute);
                console.log("fareType:", fareType);
                console.log("passengerQuantity:", passengerQuantity);
                console.log("passengerQuantity:", distance);
                console.log("passengerQuantity:", transactionNumber);
                console.log("passengerQuantity:", driverName);
                console.log("passengerQuantity:", paymentMethod);
                if (isCashPayment) {
                    // Cash payment logic
                    const response = await fetch('<?= $_SERVER['PHP_SELF']; ?>', {
                        method: 'POST',
                        body: JSON.stringify({
                            rfid: rfid,
                            fromRoute: fromRoute,
                            toRoute: toRoute,
                            fareType: fareType,
                            passengerQuantity: passengerQuantity,
                            transactionNumber: transactionNumber,
                            distance: distance,
                            driverName: driverName
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();
                    if (data.status === 'error') {
                        Swal.fire('Error', data.message, 'error');
                        return;
                    }

                    totalFare = baseFare;
                    if (distance > 4) {
                        totalFare += (distance - 4) * <?php echo $additional_fare; ?>;
                    }
                    totalFare *= passengerQuantity;
                } else {
                    console.log("rfid:", rfid);
                    console.log("fromRoute:", fromRoute);
                    console.log("toRoute:", toRoute);
                    console.log("fareType:", fareType);
                    console.log("passengerQuantity:", passengerQuantity);
                    console.log("passengerQuantity:", transactionNumber);
                    console.log("passengerQuantity:", paymentMethod);
                    // RFID payment logic
                    const response = await fetch('<?= $_SERVER['PHP_SELF']; ?>', {
                        method: 'POST',
                        body: JSON.stringify({
                            rfid: rfid,
                            fromRoute: fromRoute,
                            toRoute: toRoute,
                            fareType: fareType,
                            passengerQuantity: passengerQuantity,
                            transactionNumber: transactionNumber,
                            distance: distance,
                            driverName: driverName
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json(); // Await the JSON response here

                    if (data.status === 'error') {
                        Swal.fire('Error', data.message, 'error');
                        return;
                    }

                    totalFare = data.fare * passengerQuantity;
                }

                totalFare = totalFare.toFixed(0) + ".00";
                showReceipt(fromRoute, toRoute, fareType, totalFare, conductorName, transactionNumber, distance, paymentMethod);

            } catch (error) {
                console.error('Error fetching balance and processing fare:', error);
                Swal.fire('Error', 'An error occurred while processing your payment. Please try again.', 'error');
            }
        }

        let receiptShown = false;

        function showReceipt(fromRoute, toRoute, fareType, totalFare, conductorName, transactionNumber, distance, paymentMethod) {
            if (receiptShown) return; // Prevent showing the receipt again

            receiptShown = true;
            const driverName = "<?= $_SESSION['driver_name']; ?>";  // PHP variable for driver name
            const busNumber = "<?= $bus_number; ?>";  // PHP variable for bus number

            Swal.fire({
                html: `
        <h3>Receipt</h3>
        <strong>Transaction Number:</strong> ${transactionNumber}<br>
        <strong>Bus No.:</strong> ${busNumber}<br>
        <strong>Date:</strong> ${new Date().toLocaleDateString()}<br>
        <strong>Time:</strong> ${new Date().toLocaleTimeString()}<br>
        <strong>From:</strong> ${fromRoute.route_name}<br>
        <strong>To:</strong> ${toRoute.route_name}<br>
        <strong>Distance:</strong> ${distance} km<br>
        <strong>Driver:</strong> ${driverName}<br> <!-- Added Driver Name -->
        <strong>CONDUCTOR:</strong> ${conductorName}<br>
        <strong>Passenger Type:</strong> ${fareType}<br>
          <strong>Payment Method:</strong> ${paymentMethod}<br>
        <div style="font-size: 22px; font-weight: bold;">₱${totalFare}</div><br>
        <p>Thank you for riding with us!</p>
        `,
                didClose: () => {
                    // Trigger the PHP print function here using an AJAX request
                    $.post('print_receipt.php', {
                        fromRoute: fromRoute,
                        toRoute: toRoute,
                        fareType: fareType,
                        totalFare: totalFare,
                        conductorName: conductorName,
                        driverName: driverName, // Pass driver name to print if needed
                        busNumber: busNumber,
                        transactionNumber: transactionNumber,
                        distance: distance,
                        paymentMethod: paymentMethod
                    }, function (response) {
                        console.log("Receipt printed successfully!");
                        location.reload();
                    }).fail(function () {
                        console.error("Failed to print receipt.");

                    });
                }
            });
        }

    </script>
</body>

</html>