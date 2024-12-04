<?php
session_start();
include 'config/connection.php';



// Assume we have the RFID scanned user ID
$rfidUserId = $_POST['user_id']; // Get this from your RFID reader input
$fareAmount = 50.00; // Set your bus fare amount

// Fetch the user’s current balance
$userQuery = "SELECT balance FROM useracc WHERE id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $rfidUserId);
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
        $updateStmt->bind_param("di", $newBalance, $rfidUserId);
        $updateStmt->execute();

        // Insert into revenue table
        $insertRevenueQuery = "INSERT INTO revenue (user_id, amount, transaction_type) VALUES (?, ?, 'debit')";
        $revenueStmt = $conn->prepare($insertRevenueQuery);
        $revenueStmt->bind_param("id", $rfidUserId, $fareAmount);
        $revenueStmt->execute();

        // Success message
        $_SESSION['success_message'] = 'Fare deducted successfully!';
    } else {
        // Insufficient balance
        $_SESSION['error_message'] = 'Insufficient balance. Please load more funds.';
    }
} else {
    $_SESSION['error_message'] = 'User not found!';
}

// Redirect to the same page to avoid resubmission
header("Location: " . $_SERVER['PHP_SELF']);
exit;
?>