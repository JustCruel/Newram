<?php
// Database connection details (use the connection created above)
$host = 'localhost'; // Database host
$dbname = 'ramstardb'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create PDO instance for MySQL connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Fare calculation function
function calculateFare($distance) {
    $baseFare = 14; // First 4 km
    $additionalFare = 2; // Additional fare per km

    if ($distance <= 4) {
        return $baseFare;
    } else {
        return $baseFare + (($distance - 4) * $additionalFare);
    }
}

// Process RFID payment function
function processPayment($rfidId, $fare) {
    global $pdo; // Use the global PDO connection
    
    // Fetch user account from database using the RFID ID (account_number)
    $sql = "SELECT * FROM useracc WHERE account_number = :rfidId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['rfidId' => $rfidId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Get the current balance from the database
        $currentBalance = $user['balance'];

        // Check if the balance is sufficient for the fare
        if ($fare > $currentBalance) {
            return json_encode(['status' => 'error', 'message' => 'Insufficient balance']);
        } else {
            // Deduct fare from the current balance
            $newBalance = $currentBalance - $fare;

            // Update the balance in the database
            $updateSql = "UPDATE useracc SET balance = :newBalance WHERE account_number = :rfidId";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute(['newBalance' => $newBalance, 'rfidId' => $rfidId]);

            return json_encode([
                'status' => 'success',
                'message' => 'Payment successful',
                'new_balance' => $newBalance
            ]);
        }
    } else {
        return json_encode(['status' => 'error', 'message' => 'Invalid RFID ID']);
    }
}

// Handling AJAX requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process RFID payment
    if (isset($_POST['rfid_id']) && isset($_POST['fare'])) {
        $rfidId = $_POST['rfid_id'];
        $fare = $_POST['fare'];
        echo processPayment($rfidId, $fare);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Calculate fare based on start and end stops
    if (isset($_GET['start_stop']) && isset($_GET['end_stop'])) {
        $startStop = $_GET['start_stop'];
        $endStop = $_GET['end_stop'];

        // Distances between major stations along the national highway (in km)
        $distances = [
            'Zaragoza' => ['Santa Rosa' => 15, 'Cabanatuan Terminal' => 25],
            'Santa Rosa' => ['Zaragoza' => 15, 'Cabanatuan Terminal' => 10],
            'Cabanatuan Terminal' => ['Zaragoza' => 25, 'Santa Rosa' => 10],
        ];

        // Calculate the distance for the selected route
        if (isset($distances[$startStop][$endStop])) {
            $distance = $distances[$startStop][$endStop];
            $fare = calculateFare($distance);
            echo json_encode(['fare' => $fare]);
        } else {
            echo json_encode(['error' => 'Invalid route']);
        }

        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        select, input, button {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .fare-info, .payment-info, .receipt-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Bus Fare Management System</h1>
        
        <!-- Starting point and destination -->
        <label for="start-stop">Select Starting Point:</label>
        <select id="start-stop">
            <option value="Zaragoza">Zaragoza</option>
            <option value="Santa Rosa">Santa Rosa</option>
            <option value="Cabanatuan Terminal">Cabanatuan Terminal</option>
        </select>

        <label for="end-stop">Select Destination:</label>
        <select id="end-stop">
            <option value="Zaragoza">Zaragoza</option>
            <option value="Santa Rosa">Santa Rosa</option>
            <option value="Cabanatuan Terminal">Cabanatuan Terminal</option>
        </select>

        <button onclick="calculateFare()">Calculate Fare</button>

        <div id="fare-info" class="fare-info"></div>

        <!-- RFID Card Payment -->
        <label for="rfid">Enter RFID Card ID:</label>
        <input type="text" id="rfid" placeholder="Enter RFID ID">

        <button onclick="processPayment()">Process Payment</button>

        <div id="payment-info" class="payment-info"></div>

        <!-- Receipt -->
        <div id="receipt-info" class="receipt-info"></div>
    </div>

    <script>
        // Function to calculate fare based on start and end stops
        function calculateFare() {
            const startStop = document.getElementById('start-stop').value;
            const endStop = document.getElementById('end-stop').value;

            // Send AJAX request to PHP backend to calculate the fare
            fetch(`?start_stop=${startStop}&end_stop=${endStop}`)
                .then(response => response.json())
                .then(data => {
                    if (data.fare) {
                        document.getElementById('fare-info').innerHTML = `Fare: ${data.fare} pesos`;
                    } else if (data.error) {
                        document.getElementById('fare-info').innerHTML = `Error: ${data.error}`;
                    }
                });
        }

        // Function to process payment via RFID
        function processPayment() {
            const rfidId = document.getElementById('rfid').value;
            const fare = parseFloat(document.getElementById('fare-info').textContent.split(' ')[1]);

            // Send AJAX request to PHP backend to process the payment
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `rfid_id=${rfidId}&fare=${fare}`
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('payment-info').innerHTML = data.message;
                if (data.status === 'success') {
                    generateReceipt(rfidId, fare, data.new_balance);
                }
            });
        }

        // Function to generate receipt
        function generateReceipt(rfidId, fare, newBalance) {
            const startStop = document.getElementById('start-stop').value;
            const endStop = document.getElementById('end-stop').value;

            document.getElementById('receipt-info').innerHTML = `
                <strong>Receipt</strong><br>
                RFID ID: ${rfidId}<br>
                Start Stop: ${startStop}<br>
                End Stop: ${endStop}<br>
                Fare: ${fare} pesos<br>
                New Balance: ${newBalance} pesos<br>
                Transaction Time: ${new Date().toLocaleString()}
            `;
        }
    </script>

</body>
</html>
