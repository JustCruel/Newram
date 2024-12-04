<?php
session_start();
include 'config/connection.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: log-in.php");
    exit;
}

// Initialize variables
$fareAmount = 50.00; // Set your bus fare amount
$successMessage = '';
$errorMessage = '';

// Process the RFID tap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfidAccountNumber = $_POST['account_number']; // Get account number from RFID input

    // Fetch the user’s current balance using account number
    $userQuery = "SELECT id, balance FROM users1 WHERE account_number = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $rfidAccountNumber); // Assuming account_number is a string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($user['balance'] >= $fareAmount) {
            // Deduct the fare from user's balance
            $newBalance = $user['balance'] - $fareAmount;

            // Update the user's balance
            $updateBalanceQuery = "UPDATE users1 SET balance = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateBalanceQuery);
            $updateStmt->bind_param("di", $newBalance, $user['id']);
            $updateStmt->execute();

            // Insert into revenue table
            $insertRevenueQuery = "INSERT INTO revenue (user_id, amount, transaction_type) VALUES (?, ?, 'debit')";
            $revenueStmt = $conn->prepare($insertRevenueQuery);
            $revenueStmt->bind_param("id", $user['id'], $fareAmount);
            $revenueStmt->execute();

            // Success message
            $successMessage = 'Fare deducted successfully!';
        } else {
            // Insufficient balance
            $errorMessage = 'Insufficient balance. Please load more funds.';
        }
    } else {
        $errorMessage = 'User not found!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
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

        <?php if ($successMessage): ?>
            <div class="alert alert-success" role="alert">
                <?= $successMessage ?>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="account_number" class="form-label">RFID Account Number</label>
                <input type="text" class="form-control" id="account_number" name="account_number" required>
            </div>
            <button type="submit" class="btn btn-primary">Deduct Fare</button>
        </form>
    </div>
</body>

</html>