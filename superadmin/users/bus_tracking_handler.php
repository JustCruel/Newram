<?php
session_start();
include '../config/connection.php';

// Check if the GPS coordinates are available
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = $_POST['gps_latitude'];
    $longitude = $_POST['gps_longitude'];

    // Here you can log the coordinates, update the database, etc.
    // For example, insert into a bus_tracking table
    $insertQuery = "INSERT INTO bus_tracking (bus_id, latitude, longitude, tracked_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $busId = 1; // Assuming a bus ID for this example
    $stmt->bind_param("idd", $busId, $latitude, $longitude);

    if ($stmt->execute()) {
        $_SESSION['successMessage'] = "Bus location updated successfully!";
    } else {
        $_SESSION['errorMessage'] = "Failed to update bus location.";
    }

    header("Location: bus_tracking.php");
    exit;
}
?>