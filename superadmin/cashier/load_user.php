<?php
session_start();
include '../config/connection.php';

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

// Initialize alerts
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;

// Clear messages after displaying
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>