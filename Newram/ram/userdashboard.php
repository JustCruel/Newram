<?php
session_start();
include 'config/connection.php'; // Ensure this file connects to your database

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: log-in.php");
    exit;
}

// Get the user's ID from the session
$userId = $_SESSION['user_id'];

// Fetch user's balance and details
$userQuery = "SELECT balance, firstname, lastname, account_number FROM users WHERE id = '$userId'";
$userResult = mysqli_query($conn, $userQuery);
$userRow = mysqli_fetch_assoc($userResult);
$userBalance = $userRow['balance'];
$firstname = $userRow['firstname'];
$lastname = $userRow['lastname'];
$account_number = $userRow['account_number'];

// Fetch transaction history
$transactionsQuery = "SELECT * FROM transactions WHERE user_id = '$userId' ORDER BY transaction_date DESC";
$transactionsResult = mysqli_query($conn, $transactionsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Dashboard</title>
</head>

<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname); ?>'s Dashboard</h1>
        <h3>Account Number: <?php echo htmlspecialchars($account_number); ?></h3>
        <h3>Your Balance: $<?php echo number_format($userBalance, 2); ?></h3>

        <h2>Transaction History</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount Loaded</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($transactionsResult) > 0): ?>
                    <?php while ($transaction = mysqli_fetch_assoc($transactionsResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['id']); ?></td>
                            <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>