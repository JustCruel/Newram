<?php
session_start();
include '../config/connection.php';
include 'sidebar.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $busNumber = $_POST['busNumber'];
    $plateNumber = $_POST['plateNumber'];
    $capacity = $_POST['capacity'];
    $status = "Available";
    $registrationDate = date("Y-m-d");
    $regTillDate = $_POST['regTillDate'];
    $busModel = $_POST['busModel'];
    $vehicleColor = $_POST['vehicleColor'];

    // Check if the bus number or plate number already exists
    $queryCheck = "SELECT * FROM businfo WHERE bus_number = ? OR plate_number = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("ss", $busNumber, $plateNumber);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // If the bus number or plate number exists, display the message
        $existsMessage = "<span style='color: red;'>Bus number or plate number already exists.</span>";
    } else {
        // If no duplicate, proceed to insert data
        $query = "INSERT INTO businfo (bus_number, plate_number, capacity, statusofbus, registration_date, last_service_date, bus_model, vehicle_color, status)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssisissss", $busNumber, $plateNumber, $capacity, $status, $registrationDate, $regTillDate, $busModel, $vehicleColor, $status);

            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Bus Information Saved Successfully',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'businfo.php';
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error saving bus information',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error preparing query',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/sidebars.css">
    <style>
        h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: transparent;
            /* Make the text color transparent */
            background-image: linear-gradient(to right, #f1c40f, #e67e22);
            background-clip: text;
            -webkit-background-clip: text;
            /* WebKit compatibility */
            -webkit-text-fill-color: transparent;
            /* Ensures only the gradient is visible */
            -webkit-text-stroke: 0.5px black;
            /* Outline effect */
        }

            

        .form-control {
            border: 2px solid #f1c40f;
            /* Adds a blue border */
            border-radius: 5px;
            /* Rounds the corners */
            padding: 8px;
            /* Adds padding for better appearance */
            transition: border-color 0.3s, box-shadow 0.3s;
            /* Smooth transition effects */
        }

        .form-control:focus {
            border-color: solid #f1c40f;
            /* Changes the border to green on focus */
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
            /* Adds a subtle shadow effect on focus */
            outline: none;
            /* Removes the default outline */
        }

        .form-control::placeholder {
            color: #6c757d;
            /* Placeholder text color */
            font-style: italic;
            /* Optional: Makes placeholder text italic */
        }

        select.form-control {
            border: 2px solid #f1c40f;
            /* Adds a blue border to select dropdowns */
            border-radius: 5px;
            /* Rounds the corners */
            padding: 8px;
            /* Adds padding */
        }

        select.form-control:focus {
            border-color: solid #f1c40f;
            /* Changes the border to green on focus */
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
            /* Adds a subtle shadow effect on focus */
            outline: none;
            /* Removes the default outline */
        }

        form .btn-primary:hover {
            background: linear-gradient(to right, #f1c40f, #e67e22);
            transform: scale(1.1);
        }

        /* SweetAlert2 styling */
        .swal2-popup {
            font-size: 1.1rem !important;
            font-family: 'Arial', sans-serif !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1.text-center {
                font-size: 2rem;
            }

            .container {
                padding: 15px 20px;
            }

            form .btn-primary {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
<div id="main-content" class="container mt-4">

        <h2>Register Bus Information Form</h2>
        <form action="" method="POST" id="busInfoForm">
            <div class="form-group">
                <label for="busNumber">Bus Number</label>
                <input type="text" class="form-control" id="busNumber" name="busNumber" required>
                <div id="busNumberMessage"></div> <!-- Message for Bus Number -->
            </div>

            <div class="form-group">
                <label for="plateNumber">Plate Number</label>
                <input type="text" class="form-control" id="plateNumber" name="plateNumber" required>
                <div id="plateNumberMessage"></div> <!-- Message for Plate Number -->
            </div>

            <div class="form-group">
                <label for="capacity">Bus Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>


            <div class="form-group">
                <label for="regTillDate">Registered Till Date</label>
                <input type="date" class="form-control" id="regTillDate" name="regTillDate" required>
            </div>

            <div class="form-group">
                <label for="busModel">Bus Model</label>
                <select class="form-control" id="busModel" name="busModel" required>
                    <option value="">Select a Bus Model</option>
                    <option value="JMC">JMC</option>
                    <option value="model2">Model 2</option>
                    <option value="model3">Model 3</option>

                    <!-- Add more options as needed -->
                </select>
            </div>


            <div class="form-group">
                <label for="vehicleColor">Vehicle Color</label>
                <input type="text" class="form-control" id="vehicleColor" name="vehicleColor" required>
            </div>

            <button type="submit" class="btn btn-primary" id="submitButton">Save Bus Information</button>
        </form>

    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/main.js"></script>
    <script src="../js/sidebar.js"></script>
    <script>
        document.getElementById('busInfoForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save this bus information?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        });

        $(document).ready(function () {
            // Function to check if bus number or plate number exists
            function checkExistence(field, value) {
                $.ajax({
                    url: 'validate.php',
                    method: 'POST',
                    data: field + '=' + value,
                    success: function (response) {
                        var messageElement = $("#" + field + "Message");
                        if (response === "exists") {
                            messageElement.html("<span style='color: red;'>Bus number or plate number already exists.</span>");
                            $('#submitButton').prop('disabled', true);
                        } else {
                            messageElement.html(""); // Clear message if not exists
                            $('#submitButton').prop('disabled', false);
                        }
                    }
                });
            }

            // Event listener for bus number input
            $('#busNumber').on('input', function () {
                var busNumber = $(this).val();
                if (busNumber.length > 0) {
                    checkExistence('busNumber', busNumber);
                } else {
                    $("#busNumberMessage").html(""); // Clear message if input is empty
                }
            });

            // Event listener for plate number input
            $('#plateNumber').on('input', function () {
                var plateNumber = $(this).val();
                if (plateNumber.length > 0) {
                    checkExistence('plateNumber', plateNumber);
                } else {
                    $("#plateNumberMessage").html(""); // Clear message if input is empty
                }
            });
        });

        document.getElementById('busNumber').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/[^A-Za-z0-9]/g, '');
        });

        document.getElementById('plateNumber').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/[^A-Za-z0-9]/g, '');
        });

    </script>
</body>

</html>