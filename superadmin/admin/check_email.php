<?php
// check_email.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/connection.php'; // Make sure to include your database connection

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare statement to check email existence
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM useracc WHERE email = ?");
    
    // Bind the email parameter to the statement
    mysqli_stmt_bind_param($stmt, 's', $email);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    
    // Close the statement
    mysqli_stmt_close($stmt);

    // Return response in JSON format
    header('Content-Type: application/json');
    echo json_encode(['exists' => $count > 0]);
} else {
    echo json_encode(['error' => 'No email provided']);
}
?>
