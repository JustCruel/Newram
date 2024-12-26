<?php
// Database connection (ensure this file connects to your database)
include "../config/connection.php";

// Query to get drivers
$query = "SELECT id, name FROM useracc WHERE role = 'Driver'";
$result = $conn->query($query);

$drivers = [];
while ($row = $result->fetch_assoc()) {
    $drivers[] = $row;
}

// Return the list of drivers as JSON
echo json_encode($driver);
?>
