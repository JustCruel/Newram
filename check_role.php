<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

// Define folder access for each role
$allowed_folders = [
    'Superadmin' => ['admin', 'cashier', 'conductor', 'user'],
    'Admin' => ['admin'],
    'Cashier' => ['cashier'],
    'Conductor' => ['conductor'],
    'User' => ['user']
];

// Get the current folder name
$current_folder = basename(dirname($_SERVER['PHP_SELF']));

// Check if the user has access to this folder
if (!in_array($current_folder, $allowed_folders[$_SESSION['role']])) {
    header("HTTP/1.1 403 Forbidden");
    echo "Access Denied.";
    exit();
}
?>