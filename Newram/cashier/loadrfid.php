<?php
session_start();
include 'config/connection.php';

// Ensure no output before this point
if (!isset($_SESSION['email'])) {
    header("Location: log-in.php");
    exit;
}

include 'sidebaradmin.php';

// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM users1";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

// Initialize search variables
$searchResult = null;
$searchError = null;

// Handle search request
if (isset($_POST['search_account'])) {
    $accountNumber = mysqli_real_escape_string($conn, $_POST['account_number']);

    if (!empty($accountNumber)) {
        $searchQuery = "SELECT * FROM users1 WHERE account_number LIKE '%$accountNumber%'";
        $searchResult = mysqli_query($conn, $searchQuery);

        if (mysqli_num_rows($searchResult) == 0) {
            $searchError = "No user found with Account Number: " . htmlspecialchars($accountNumber);
        }
    } else {
        $searchError = "Please enter an account number.";
    }
}

// Handle balance loading
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_account_number']) && isset($_POST['balance'])) {
    $userAccountNumber = mysqli_real_escape_string($conn, $_POST['user_account_number']);
    $balanceToLoad = mysqli_real_escape_string($conn, $_POST['balance']);

    // Fetch the user ID based on the account number
    $userQuery = "SELECT id FROM users1 WHERE account_number = '$userAccountNumber'";
    $userResult = mysqli_query($conn, $userQuery);
    $userRow = mysqli_fetch_assoc($userResult);

    if ($userRow) {
        $userId = $userRow['id'];

        // Update the user's balance in the database
        $updateBalanceQuery = "UPDATE users1 SET balance = balance + ? WHERE account_number = ?";
        $stmt = $conn->prepare($updateBalanceQuery);
        $stmt->bind_param("ds", $balanceToLoad, $userAccountNumber);

        if ($stmt->execute()) {
            // Insert transaction record
            $insertTransactionQuery = "INSERT INTO transactions (user_id, amount, transaction_type) VALUES (?, ?, 'credit')";
            $transactionStmt = $conn->prepare($insertTransactionQuery);
            $transactionStmt->bind_param("sd", $userId, $balanceToLoad);

            if ($transactionStmt->execute()) {
                $_SESSION['success_message'] = 'loaded successfully!';
            } else {
                $_SESSION['error_message'] = 'Balance loaded, but failed to record transaction: ' . mysqli_error($conn);
            }
        } else {
            $_SESSION['error_message'] = 'Error loading balance: ' . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = 'User not found!';
    }


}

// Initialize alerts
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;

// Clear messages after displaying
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css"> <!-- Your custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f0f0f0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            color: #001f3f;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100vh;
            border-right: 1px solid #e0e0e0;
        }

        .main-content {
            flex: 1;
            margin: 0;
            padding: 20px;
            overflow-y: auto;
            background-color: #ffffff;
            border-left: 1px solid #e0e0e0;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .alert {
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 150px;
            }

            h2 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <div class="main-content">
        <h1>Load User</h1>

        <!-- User Count -->
        <div class="dashboard-item">
            <h3>Total Users</h3>
            <p><?php echo $userCount; ?></p>
        </div>

        <!-- Search Bar -->
        <div class="search-bar mb-4">
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="account_number" class="form-control" placeholder="Enter Account Number"
                        required>
                    <button type="submit" name="search_account" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

        <?php if ($searchError): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $searchError; ?>
            </div>
        <?php endif; ?>

        <?php if ($searchResult && mysqli_num_rows($searchResult) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Account Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($searchResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['account_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                            <td>₱<?php echo number_format($row['balance'], 2); ?></td>
                            <td>
                                <button class="btn btn-success" onclick="loadUser('<?php echo $row['account_number']; ?>')">Load
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="loadBalanceModal" tabindex="-1" aria-labelledby="loadBalanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loadBalanceModalLabel">Load </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loadBalanceForm" method="POST" action="">
                        <div class="mb-3">
                            <label for="balance" class="form-label">Balance</label>
                            <input type="number" id="balance" name="balance" class="form-control"
                                placeholder="Enter Load" required>
                        </div>
                        <input type="hidden" id="user_account_number" name="user_account_number">

                        <!-- Buttons for predefined amounts -->
                        <div class="amount-buttons mb-3">
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(100)">₱100</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(150)">₱150</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(200)">₱200</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(250)">₱250</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(300)">₱300</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(350)">₱350</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(400)">₱400</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(450)">₱450</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(500)">₱500</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(550)">₱550</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(600)">₱600</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(650)">₱650</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(700)">₱700</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(750)">₱750</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(800)">₱800</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(850)">₱850</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(900)">₱900</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(950)">₱950</button>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="setBalance(1000)">₱1000</button>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Load</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        function setBalance(amount) {
            document.getElementById('balance').value = amount;
        }

        function loadUser(accountNumber) {
            document.getElementById('user_account_number').value = accountNumber;
            var modal = new bootstrap.Modal(document.getElementById('loadBalanceModal'));
            modal.show();
        }

        <?php if ($successMessage): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $successMessage; ?>',
            });
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?php echo $errorMessage; ?>',
            });
        <?php endif; ?>
    </script>
</body>

</html>