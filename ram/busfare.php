<?php
session_start();
include 'config/connection.php';



// Initialize variables
$fareAmount = 50.00; // Set your bus fare amount
$successMessage = '';
$errorMessage = '';

// Process the RFID tap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfidAccountNumber = $_POST['account_number']; // Get account number from RFID input

    // Fetch the user’s current balance using account number
    $userQuery = "SELECT id, balance FROM useracc WHERE account_number = ?";
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
            $updateBalanceQuery = "UPDATE useracc SET balance = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateBalanceQuery);
            $updateStmt->bind_param("di", $newBalance, $user['id']);
            $updateStmt->execute();

            // Insert into revenue table
            $insertRevenueQuery = "INSERT INTO revenue (user_id, amount, transaction_type) VALUES (?, ?, 'debit')";
            $revenueStmt = $conn->prepare($insertRevenueQuery);
            $revenueStmt->bind_param("id", $user['id'], $fareAmount);
            $revenueStmt->execute();

            // Set success message
            $_SESSION['successMessage'] = 'Fare deducted successfully!';
        } else {
            // Insufficient balance
            $_SESSION['errorMessage'] = 'Insufficient balance. Please load more funds.';
        }
    } else {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->
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
            <button type="submit" class="btn btn-primary">Deduct Fare</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Automatically focus on RFID input field
            document.getElementById('account_number').focus();
        });

        <?php if ($successMessage): ?>
            // Show SweetAlert for success
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= $successMessage ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Keep the page ready for the next input
                document.getElementById('account_number').focus();
            });
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            // Show SweetAlert for error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= $errorMessage ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Focus back on the input field after error
                document.getElementById('account_number').focus();
            });
        <?php endif; ?>
    </script>
</body>

</html>