<?php
session_start();
include '../config/connection.php';

// Function to fetch user count
function fetchUserCount($conn)
{
    $userCountQuery = "SELECT COUNT(*) as userCount FROM users1";
    $userCountResult = mysqli_query($conn, $userCountQuery);
    $userCountRow = mysqli_fetch_assoc($userCountResult);
    return $userCountRow['userCount'];
}

// Function to handle search request
function handleSearch($conn)
{
    $searchResult = null;
    $searchError = null;

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

    return [$searchResult, $searchError];
}

// Function to handle balance loading
function handleBalanceLoading($conn)
{
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
                    $_SESSION['success_message'] = 'Loaded successfully!';
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
}

// Initialize alerts
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;

// Clear messages after displaying
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

// Fetch user count
$userCount = fetchUserCount($conn);

// Handle search and balance loading
list($searchResult, $searchError) = handleSearch($conn);
handleBalanceLoading($conn);

// If you are returning results for AJAX
if (isset($_POST['search_account'])) {
    echo json_encode([
        'userCount' => $userCount,
        'searchResult' => $searchResult,
        'searchError' => $searchError,
    ]);
    exit; // Make sure to exit after echoing JSON for AJAX
}
?>