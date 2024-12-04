<?php
// Your existing code for fetching municipalities
include 'config/connection.php';

if (isset($_GET['province_id'])) {
    $province_id = $_GET['province_id'];
    $province_id = mysqli_real_escape_string($conn, $province_id); // Sanitize input

    $selectMunicipalities = "SELECT municipality_id, municipality FROM municipalities WHERE fk_provinceid='$province_id'";
    $resultMunicipalities = mysqli_query($conn, $selectMunicipalities);

    // Check for query errors
    if (!$resultMunicipalities) {
        echo 'Error: ' . mysqli_error($conn);
        exit;
    }

    $options = '<option value="">Select Municipality</option>';
    while ($row = mysqli_fetch_assoc($resultMunicipalities)) {
        $options .= '<option value="' . htmlspecialchars($row['municipality_id']) . '">' . htmlspecialchars($row['municipality']) . '</option>';
    }
    echo rtrim($options); // Trim to remove any trailing whitespace
}
?>