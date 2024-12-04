<?php
session_start();
include 'config/connection.php';

if (!isset($_SESSION['email'])) {
    // Redirect to the login page
    header("Location: log-in.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Monthly Revenue Chart</title>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: LightGray;
        }

        .dashboard-item {
            background-color: rgb(87 107 237);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 20px;
        }

        .dashboard-item h3 {
            margin-bottom: 30px;
            color: #4caf50;
        }

        .dashboard-item p {
            font-size: 20px;
            color: #333;
        }

        .dashboard {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(87 107 237);
            overflow-x: hidden;
            padding-top: 20px;
            transition: 0.5s;
        }

        .sidenav a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            font-weight: 500;
        }

        .sidenav a:hover {
            background-color: rgb(87 107 237);
        }

        .content {
            margin-left: 250px;
            padding: 30px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: rgb(87 107 237);
            color: white;
            padding: 10px 15px;
            border: none;
            position: fixed;
            top: 20px;
            left: 10px;
            z-index: 2;
        }

        .dashboard-item i {
            font-size: 40px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="sidenav" id="mySidenav">
            <button class="openbtn" onclick="toggleNav()">☰</button>
            <a href="Dashboardadmin.php">Home</a>
            <a href="Registration.php">Registration</a>
            <a href="userload.php">Load User</a>
            <a href="users.php">View Registered Users</a>
            <a href="Revenue.php">Revenue</a>
            <a href="audit.php" class="text-white">Audit Records</a>
            <a href="Logout.php">Logout</a>
        </nav>
    </div>

    <!-- Page content -->
    <div class="content">
        <h3>Audit Records</h3>
        <table class="table table-striped">
            <thead class="custom-thead">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from the database
                $sql = "SELECT * FROM audit";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["audit_id"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["logintime"] . "</td>";
                        echo "<td>" . $row["logouttime"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No audit records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div style="text-align: center;">
            <button id="btnback" onclick="goBack()" class="go-back-button">Go Back</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }
        function toggleNav() {
            var sidebar = document.getElementById("mySidenav");
            var btn = document.querySelector(".openbtn");
            if (sidebar.style.width === "0px" || sidebar.style.width === "") {
                sidebar.style.width = "250px";
                sidebar.classList.add("opened");
                btn.style.left = "250px";
                btn.innerHTML = "✕"; // Change button text to "close"
            } else {
                sidebar.style.width = "0";
                sidebar.classList.remove("opened");
                btn.style.left = "10px";
                btn.innerHTML = "☰"; // Change button text to "open"
            }
        }
    </script>
</body>

</html>