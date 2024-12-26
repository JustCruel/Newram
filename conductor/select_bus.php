<?php
session_start();
include '../config/connection.php';

$driver_name = isset($_SESSION['driver_name']) ? $_SESSION['driver_name'] : null;

$nameParts = explode(' ', $driver_name);
$firstname = $nameParts[0]; // First name
$middlename = isset($nameParts[1]) ? $nameParts[1] : ''; // Middle name (if present)
$lastname = isset($nameParts[2]) ? $nameParts[2] : ''; // Last name (if present)

if (isset($_POST['bus_number']) && isset($_POST['driver_name'])) {
    // Get the selected bus number and driver name
    $driver_account_number = $_SESSION['account_number']; // Ensure this is defined
    $bus_number = mysqli_real_escape_string($conn, $_POST['bus_number']);
    $driver_name = mysqli_real_escape_string($conn, $_POST['driver_name']);
    $conductor_name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; // Use session to get the conductor's name
    $email = $_SESSION['email']; // Ensure this is defined

    // Update session with the bus number, driver name, and conductor name
    $_SESSION['bus_number'] = $bus_number;
    $_SESSION['driver_account_number'] = $driver_account_number; // Set the driver account number
    $_SESSION['driver_name'] = $driver_name;
    $_SESSION['conductor_name'] = $conductor_name;
    $_SESSION['conductor_number'] = $conductor_account_number; // Ensure this is defined
    $_SESSION['email'] = $email; // Set the email variable

    // Update the database with temporary data
    $update_bus_data = "
    UPDATE businfo 
    SET driverName = '$driver_name', 
        conductorName = '$conductor_name', 
        status = 'In Transit' 
    WHERE bus_number = '$bus_number'
";

    if (mysqli_query($conn, $update_bus_data)) {
        // Split the full name into first, middle, and last name if necessary
        $nameParts = explode(' ', $driver_name);
        $firstname = $nameParts[0]; // First name
        $middlename = isset($nameParts[1]) ? $nameParts[1] : ''; // Middle name (if present)
        $lastname = isset($nameParts[2]) ? $nameParts[2] : '';
      

        // Update the driver status in the useracc table to 'driving'
        $updateDriverStatusStmt = $conn->prepare("UPDATE useracc SET driverStatus = 'driving' WHERE account_number =?");
        if ($updateDriverStatusStmt) {
            $updateDriverStatusStmt->bind_param("s", $lastname);
            if ($updateDriverStatusStmt->execute()) {
                // Redirect to the conductor dashboard or another page after saving
                header("Location: busfare.php");
                exit();
            } else {
                // Error updating driver status
                echo "Error updating driver status: " . $conn->error;
            }
            $updateDriverStatusStmt->close();
        } else {
            // Error preparing driver status update statement
            echo "Error preparing driver status update statement: " . $conn->error;
        }
    } else {
        // Handle database error
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Handle invalid submission or redirection
    header("Location: ../login.php");
    exit();
}
?>
