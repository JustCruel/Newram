<?php
session_start();
include '../config/connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['rfid']) || empty($data['rfid'])) {
    echo json_encode(['success' => false, 'message' => 'RFID is required.']);
    exit;
}

$rfid = $data['rfid'];

// Fetch conductor name and bus number
$stmt = $conn->prepare("SELECT u.firstname, u.lastname, t.bus_number
FROM useracc u
LEFT JOIN transactions t ON t.conductor_id = u.account_number
WHERE u.account_number = ?
ORDER BY t.transaction_date DESC
LIMIT 1;
;
");
$stmt->bind_param("s", $rfid);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $bus_number);

if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'No conductor found for this RFID.']);
    $stmt->close();
    $conn->close();
    exit;
}

$conductor_name = trim($firstname . ' ' . $lastname);
$bus_number = $bus_number ?? 'No Bus Assigned'; // Default value for missing bus_number
$stmt->close();

// Fetch total load and total fare
$stmt = $conn->prepare("
    SELECT 
        IFNULL(SUM(t.amount), 0) AS total_load,
        IFNULL(SUM(p.fare), 0) AS total_fare
    FROM transactions t
    LEFT JOIN passenger_logs p ON p.bus_number = t.bus_number
    WHERE t.status = 'notremitted' AND t.bus_number = ? AND t.conductor_id = ? 
    AND DATE(t.transaction_date) = CURDATE()
    AND p.status = 'notremitted' AND p.conductor_name = ?
    AND DATE(p.timestamp) = CURDATE();
");

$stmt->bind_param("sss", $bus_number, $rfid, $conductor_name);
$stmt->execute();
$stmt->bind_result($total_load, $total_fare);

if ($stmt->fetch()) {
    echo json_encode([
        'success' => true,
        'conductor_name' => $conductor_name,
        'bus_number' => $bus_number,
        'total_load' => number_format((float) $total_load, 2, '.', ''),
        'total_fare' => number_format((float) $total_fare, 2, '.', '')
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error fetching total fare and load.']);
}

$stmt->close();
$conn->close();
?>