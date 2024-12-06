<?php
session_start();
include '../config/connection.php';
include 'sidebar.php';// Make sure to include your database connection script
// Assuming you have the user id in session
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $busNumber = $_POST['busNumber'];
    $plateNumber = $_POST['plateNumber'];
    $busType = $_POST['busType'];
    $capacity = $_POST['capacity'];

    $status = $_POST['status'];
    $registrationDate = $_POST['registrationDate'];
    $lastServiceDate = $_POST['lastServiceDate'];
    $busModel = $_POST['busModel'];
    $vehicleColor = $_POST['vehicleColor'];

    // Prepare SQL query to insert data into buses table
    $query = "INSERT INTO businfo (bus_number, plate_number, bus_type, capacity, statusofbus, registration_date, last_service_date, bus_model, vehicle_color)
              VALUES (?, ?, ?, ?, ?, ?,  ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssisisss", $busNumber, $plateNumber, $busType, $capacity, $status, $registrationDate, $lastServiceDate, $busModel, $vehicleColor);

        if ($stmt->execute()) {
            echo "<script>alert('Bus Information Saved Successfully'); window.location.href = 'businfo.php';</script>";
        } else {
            echo "<script>alert('Error saving bus information');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing query');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Information Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        h2 {
            color: black;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>Bus Information Form</h2>
        <form action="" method="POST" id="busInfoForm">
            <div class="form-group">
                <label for="busNumber">Bus Number</label>
                <input type="text" class="form-control" id="busNumber" name="busNumber" required>
            </div>

            <div class="form-group">
                <label for="plateNumber">Plate Number</label>
                <input type="text" class="form-control" id="plateNumber" name="plateNumber" required>
            </div>

            <div class="form-group">
                <label for="busType">Bus Type</label>
                <select class="form-control" id="busType" name="busType" required>
                    <option value="regular">Regular</option>
                    <option value="air-conditioned">Air-conditioned</option>
                </select>
            </div>

            <div class="form-group">
                <label for="capacity">Bus Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>

            <div class="form-group">
                <label for="route">Route</label>
                <input type="text" class="form-control" id="route" name="route" required>
            </div>

            <div class="form-group">
                <label for="status">Bus Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label for="registrationDate">Registration Date</label>
                <input type="date" class="form-control" id="registrationDate" name="registrationDate" required>
            </div>

            <div class="form-group">
                <label for="lastServiceDate">Last Service Date</label>
                <input type="date" class="form-control" id="lastServiceDate" name="lastServiceDate" required>
            </div>


            <div class="form-group">
                <label for="busModel">Bus Model</label>
                <input type="text" class="form-control" id="busModel" name="busModel">
            </div>

            <div class="form-group">
                <label for="vehicleColor">Vehicle Color</label>
                <input type="text" class="form-control" id="vehicleColor" name="vehicleColor">
            </div>

            <button type="submit" class="btn btn-primary">Save Bus Information</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>