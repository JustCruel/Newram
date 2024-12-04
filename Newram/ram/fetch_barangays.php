<?php
include 'config/connection.php'; // Include your database connection file

if (isset($_POST['municipality_id'])) {
    $municipality_id = $_POST['municipality_id'];
    $municipality_id = mysqli_real_escape_string($conn, $municipality_id); // Sanitize input

    $selectBarangays = "SELECT barangay_id, barangay FROM barangay WHERE fk_municipalityid='$municipality_id'";
    $resultBarangays = mysqli_query($conn, $selectBarangays);

    // Check for query errors
    if (!$resultBarangays) {
        echo json_encode(['error' => 'Query failed: ' . mysqli_error($conn)]);
        exit;
    }

    $barangays = [];
    while ($row = mysqli_fetch_assoc($resultBarangays)) {
        $barangays[] = [
            'id' => htmlspecialchars($row['barangay_id']),
            'barangay' => htmlspecialchars($row['barangay'])
        ];
    }

    // Return the results as JSON
    echo json_encode($barangays);
}
?>