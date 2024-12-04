<?php
session_start();
include 'config/connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: log-in.php");
    exit;
}
include 'sidebaradmin.php';
// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

$totalRevenueQuery = "SELECT SUM(amount) as totalRevenue FROM revenue WHERE transaction_type = 'debit'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult);
$totalRevenue = $totalRevenueRow['totalRevenue'] ?? 0;
// Initialize search variables
$searchResult = null;
$searchError = null;

// Handle search request
if (isset($_POST['search_id'])) {
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);

    if (!empty($userId)) {
        $searchQuery = "SELECT * FROM users WHERE id = '$userId'";
        $searchResult = mysqli_query($conn, $searchQuery);

        if (mysqli_num_rows($searchResult) == 0) {
            $searchError = "No user found with ID: $userId";
        }
    } else {
        $searchError = "Please enter a user ID.";
    }
}

// Handle balance loading
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_account_number']) && isset($_POST['balance'])) {
    $userAccountNumber = mysqli_real_escape_string($conn, $_POST['user_account_number']);
    $balanceToLoad = mysqli_real_escape_string($conn, $_POST['balance']);

    // Update the user's balance in the database
    $updateBalanceQuery = "UPDATE users SET balance = balance + '$balanceToLoad' WHERE account_number = '$userAccountNumber'";
    if (mysqli_query($conn, $updateBalanceQuery)) {
        $_SESSION['success_message'] = 'Balance loaded successfully!';
    } else {
        $_SESSION['error_message'] = 'Error loading balance: ' . mysqli_error($conn);
    }

    // Redirect to the same page to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Initialize alerts
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
$loginSuccessMessage = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : null;

// Clear messages after displaying
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
unset($_SESSION['login_success']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/dashboardadmin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Administrator Dashboard</title>

</head>

<body>


    <div class="main-content">
        <h1>Administrator Dashboard</h1>

        <?php if (isset($searchError)): ?>
            <div class="alert alert-danger">
                <?php echo $searchError; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($searchResult) && mysqli_num_rows($searchResult) > 0): ?>
            <div class="search-results">
                <h3>Search Results:</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Account Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($searchResult)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($user['account_number']); ?></td>
                                <td>
                                    <button class="btn btn-secondary btn-sm"
                                        onclick="loadUser('<?php echo htmlspecialchars($user['account_number']); ?>')">Load</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="dashboard">
            <div class="dashboard-item">
                <i class="fas fa-users"></i>
                <h3>Registered Users</h3>
                <p><?php echo $userCount; ?></p>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-desktop"></i>
                <h3>Total Terminals</h3>
                <!-- <p><?php echo $totalTerminals; ?></p> -->
            </div>
            <div class="dashboard-item">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Total Revenue</h3>
                <p>₱<?php echo number_format($totalRevenue, 2); ?></p>
            </div>

            <div class="dashboard-item">
                <i class="fas fa-car"></i>
                <h3>Total Bus</h3>
                <!--  <p><?php echo $totalVehicles; ?></p> -->
            </div>
        </div>

        <!-- Modal for Loading Balance -->
        <div class="modal fade" id="loadBalanceModal" tabindex="-1" aria-labelledby="loadBalanceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loadBalanceModalLabel">Load Balance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="loadBalanceForm" method="POST">
                            <input type="hidden" name="user_account_number" id="user_account_number">
                            <div class="mb-3">
                                <label for="balance" class="form-label">Balance to Load</label>
                                <input type="number" class="form-control" name="balance" id="balance" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Load Balance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadUser(accountNumber) {
            document.getElementById('user_account_number').value = accountNumber;
            var modal = new bootstrap.Modal(document.getElementById('loadBalanceModal'));
            modal.show();
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('loadBalanceForm').addEventListener('submit', function (e) {
                e.preventDefault();

                // Add SweetAlert confirmation before form submission
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to load this balance?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, load it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>