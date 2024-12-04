<?php
// Database connection details
include '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disabledAccountNumber = $_POST['disabledAccountNumber'];
    $newAccountNumber = $_POST['newAccountNumber'];

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Step 1: Check if the disabled card exists and is disabled
        $checkDisabled = $conn->prepare("SELECT balance FROM useracc WHERE account_number = ? AND is_disabled = TRUE");
        $checkDisabled->bind_param("s", $disabledAccountNumber);
        $checkDisabled->execute();
        $result = $checkDisabled->get_result();

        if ($result->num_rows === 1) {
            // Get balance from the disabled card
            $row = $result->fetch_assoc();
            $balanceToTransfer = $row['balance'];

            // Step 2: Update the disabled card's balance to zero
            $updateDisabledCard = $conn->prepare("UPDATE useracc SET balance = 0 WHERE account_number = ?");
            $updateDisabledCard->bind_param("s", $disabledAccountNumber);
            $updateDisabledCard->execute();

            // Step 3: Add the balance to the new card
            $updateNewCard = $conn->prepare("UPDATE useracc SET balance = balance + ? WHERE account_number = ?");
            $updateNewCard->bind_param("ds", $balanceToTransfer, $newAccountNumber);
            $updateNewCard->execute();

            // Commit transaction
            $conn->commit();

            echo "Transfer successful! Transferred ₱" . number_format($balanceToTransfer, 2) . " to the new account.";
        } else {
            echo "Error: Disabled account not found or account is not disabled.";
        }

        // Close prepared statements
        $checkDisabled->close();
        $updateDisabledCard->close();
        $updateNewCard->close();
    } catch (Exception $e) {
        // Rollback transaction if an error occurs
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
    }

    // Close the database connection
    $conn->close();
}
?>