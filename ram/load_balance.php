<?php
session_start();
include 'config/connection.php';

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: log-in.php");
    exit;
}

// Check if the email is passed in the URL
if (isset($_GET['email'])) {
    $userEmail = $_GET['email'];
} else {
    header("Location: users.php"); // Redirect if email not provided
    exit;
}

// Handle balance loading
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['balance'])) {
    $balanceToLoad = $_POST['balance']; // No need to escape, using prepared statements

    // Begin a transaction
    mysqli_begin_transaction($conn);

    try {
        // Update the user's balance in the database
        $updateBalanceQuery = "UPDATE users1 SET balance = balance + ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $updateBalanceQuery);
        mysqli_stmt_bind_param($stmt, 'is', $balanceToLoad, $userEmail);
        mysqli_stmt_execute($stmt);

        // Insert the transaction log using the user's email
        $insertTransactionQuery = "INSERT INTO transactions (user_email, amount, transaction_date) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $insertTransactionQuery);
        mysqli_stmt_bind_param($stmt, 'sd', $userEmail, $balanceToLoad);
        mysqli_stmt_execute($stmt);

        // Commit the transaction
        mysqli_commit($conn);
        echo "<script>alert('Balance loaded and transaction logged successfully!'); window.location.href='users.php';</script>";
    } catch (Exception $e) {
        // Rollback the transaction if something failed
        mysqli_rollback($conn);
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Load Balance</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Load Balance for <?php echo htmlspecialchars($userEmail); ?></h1>
        <form id="loadBalanceForm" method="POST" action="">
            <div class="mb-3">
                <label for="balance" class="form-label">Enter Amount to Load:</label>
                <input type="number" class="form-control" name="balance" id="balance" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="confirmLoad()">Load Balance</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        function confirmLoad() {
            const balance = document.getElementById('balance').value;
            if (balance <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter a valid amount.',
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to load " + balance + " to the user's balance!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, load it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('loadBalanceForm').submit(); // Submit the form if confirmed
                }
            });
        }
    </script>
</body>

</html>