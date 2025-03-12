<?php
// Assuming you have a connection to your database
include '../config/connection.php';

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);
$newAmount = $data['amount'];

if (isset($newAmount) && is_numeric($newAmount)) {
    // Save the new amount to the database (ensure you have a table for this)
    $query = "INSERT INTO modalload (balance) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $newAmount);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to add amount']);
    }
} else {
    echo json_encode(['error' => 'Invalid amount']);
}
?>