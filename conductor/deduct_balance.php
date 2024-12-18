<?php
   session_start();
include '../config/connection.php'; // Adjust path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deduct_balance'])) {
    $account_number = $_POST['deduct_user_account_number']; // Updated to match input name
    $amount = floatval($_POST['deduct_balance']); // Changed to match input name
 
    $busNumber = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    $conductorId = isset($_SESSION['account_number']) ? $_SESSION['account_number'] : null;
    // Check if the amount is valid and less than or equal to current balance
    if ($amount <= 0) {
        echo json_encode(['error' => 'Invalid amount.']);
        exit;
    }

    // Query to get current balance
    // Query to get current balance and user ID
    $query = "SELECT id, balance FROM useracc WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $account_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Get the user ID from the result

        if ($user['balance'] >= $amount) {
            $new_balance = $user['balance'] - $amount;

            // Update the user's balance
            $updateQuery = "UPDATE useracc SET balance = ? WHERE account_number = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ds", $new_balance, $account_number);

            if ($updateStmt->execute()) {
                $logQuery = "INSERT INTO transactions (user_id, account_number, amount, transaction_type, bus_number, conductor_id) 
                                       VALUES (?, ?, ?, 'Deduct', ?, ?)";
                $logStmt = $conn->prepare($logQuery);
             
                $logStmt->bind_param("isdss", $user['id'], $account_number, $amount, $busNumber, $conductorId);
                $logStmt->execute();

                echo json_encode(['success' => 'Balance deducted successfully. New balance is ₱' . number_format($new_balance, 2)]);
            } else {
                echo json_encode(['error' => 'Failed to update balance: ' . $updateStmt->error]);
            }
        } else {
            echo json_encode(['error' => 'Insufficient balance.']);
        }
    } else {
        echo json_encode(['error' => 'User  not found.']);
    }
}
?>