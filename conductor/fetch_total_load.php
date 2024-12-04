<?php
include '../config/connection.php';

if (isset($_POST['bus_number']) && isset($_POST['conductor_id'])) {
    $bus_number = $_POST['bus_number'];
    $conductor_id = $_POST['conductor_id'];

    $stmt = $conn->prepare("SELECT SUM(amount) as total_load FROM transactions WHERE bus_number = ? AND conductor_id = ?");
    $stmt->bind_param("ss", $bus_number, $conductor_id);

    if ($stmt->execute()) {
        $stmt->bind_result($total_load);
        $stmt->fetch();
        $stmt->close();

        // If no transactions, return 0
        echo json_encode(['total_load' => $total_load ?: 0]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}
?>