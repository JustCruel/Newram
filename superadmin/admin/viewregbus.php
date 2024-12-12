<?php
session_start();
include '../config/connection.php';
include '../sidebar.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

$query = "SELECT * FROM businfo";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Buses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- jQuery CDN link -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
    <style>
        h2{
            color: black;
        }
    </style>
</head>


<body>
    <div class="container mt-5">
        <h2>Registered Buses</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bus Number</th>
                    <th>Plate Number</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Registration Date</th>
                    <th>Registered Till</th>
                    <th>Bus Model</th>
                    <th>Vehicle Color</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['bus_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['plate_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['capacity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['registration_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_service_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['bus_model']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['vehicle_color']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No buses registered yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
