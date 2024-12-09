<?php
session_start();
include '../config/connection.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted fare values
    $baseFare = filter_var($_POST['base_fare'], FILTER_VALIDATE_FLOAT);
    $additionalFare = filter_var($_POST['additional_fare'], FILTER_VALIDATE_FLOAT);

    // Validate inputs
    if ($baseFare === false || $additionalFare === false) {
        die("Invalid fare values.");
    }

    try {
        // Update the fare settings in the database
        $queryUpdate = "UPDATE fare_settings SET base_fare = :baseFare, additional_fare = :additionalFare WHERE id = 1";
        $stmtUpdate = $pdo->prepare($queryUpdate);
        $stmtUpdate->execute([
            ':baseFare' => $baseFare,
            ':additionalFare' => $additionalFare
        ]);

        echo "Fare settings updated successfully!";
    } catch (PDOException $e) {
        echo "Error updating fare: " . $e->getMessage();
    }
}
?>