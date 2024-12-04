<?php
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "tourist"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'getMunicipalities') {
        $province_id = $_POST['province_id'];
        $stmt = $conn->prepare("SELECT id, name FROM municipalities WHERE province_id = ?");
        $stmt->bind_param("i", $province_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $municipalities = [];
        while ($row = $result->fetch_assoc()) {
            $municipalities[] = $row;
        }
        echo json_encode($municipalities);
    }

    if ($action == 'getBarangays') {
        $municipality_id = $_POST['municipality_id'];
        $stmt = $conn->prepare("SELECT id, name FROM barangay WHERE municipality_id = ?");
        $stmt->bind_param("i", $municipality_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $barangays = [];
        while ($row = $result->fetch_assoc()) {
            $barangays[] = $row;
        }
        echo json_encode($barangays);
    }
}

$conn->close();
?>