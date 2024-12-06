<?php
// fare_settings.php
include '../config/connection.php';

// Fetch base fare and additional fare from fare_settings table
$fareSettingsQuery = "SELECT base_fare, additional_fare FROM fare_settings LIMIT 1";
$fareSettingsResult = $conn->query($fareSettingsQuery);
$fareSettings = $fareSettingsResult->fetch_assoc();

// Return the fare settings as JSON
echo json_encode([
    'base_fare' => $fareSettings['base_fare'],
    'additional_fare' => $fareSettings['additional_fare']
]);

$conn->close();
?>