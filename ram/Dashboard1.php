<?php
session_start();
include 'config/connection.php';
if (!isset($_SESSION['email'])) {
    // Redirect to the login page
    header("Location: log-in.php");
    exit;
}

// Fetch data from the database
$query = "SELECT * FROM places";
$result = mysqli_query($conn, $query);
$places = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLACES</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dashboard-item img {
            width: 100%;
            height: 300px;
            background-size: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Override Bootstrap container padding */
        .custom-container {
            padding-top: 100px;
            padding-bottom: 100px;
        }

        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(calc(50% - 20px), 1fr)); /* Adjusted grid columns */
            gap: 20px;
            margin-left:170px;
            margin-right:-10px;
        }

        .dashboard-item {
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            height: 400px;
        }

        .dashboard-item h2 {
            margin-top: 0;
        }

        .dashboard-item p {
            margin-bottom: 10px;
        }

        .dashboard-item a {
            display: block;
            text-align: center;
            background-color: pink;
            color: white;
            padding: 10px 0;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dashboard-item a:hover {
            background-color: #45a049;
        }

        /* Style for search bar */
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input[type=text] {
            padding: 10px;
            margin: 0 auto;
            width: 50%; /* Adjusted width for better visibility */
            max-width: 400px; /* Added max-width for responsiveness */
            border: 1px solid #ced4da; /* Bootstrap border color */
            border-radius: 5px;
            box-sizing: border-box;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            background-color: rgba(133, 187, 101);
            justify-content: space-between;
            align-items: center;
            padding: 10px 10px;
            transition: 0.2s;
            z-index: 100000;
            height: 30px;
        }

        header.sticky {
            padding: 10px 10px;
            background: rgba(133, 187, 101, 0.8);
        }

        header.sticky ul li a {
            color: white;
        }

        header.sticky ul li a:hover {
            color: black;
        }

        .logo {
            margin-left: 10px;
            width: 50px;
            height: 45px;
        }

        ul, li {
            display: inline-block;
            padding: 0px 15px;
        }
        .btn-success {
    color: #fff;
    background-color: #a72852;
    border-color: #9626a

        li {
            list-style-type: none;
        }

        li .aheader {
            text-decoration: none;
            color: black;
            font-size: 15px;
            float: right;
        }

        li .aheader:hover {
            color: white;
            background-color: pink(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6));
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgba(133, 187, 101);
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
            background-color: #ddd;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
        }

        /* CSS for the open/close button */
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: red(133, 187, 101);
            color: white;
            padding: 10px 15px;
            border: none;
            position: fixed;
            top: 20px;
            left: 10px;
            z-index: 2;
        }
    </style>
</head>

<body>
<nav class="sidenav" id="mySidenav">
    <button class="openbtn" onclick="toggleNav()">☰</button>
    <a href="dashboardhome.php" class="text-white">HOME</a>
    <a href="Dashboard1.php" class="text-white">PLACES</a>
    <a href="profile.php" class="text-white">My Profile</a>
    <a href="Logout.php" class="text-white">Logout</a>
</nav>

<div class="container custom-container">
    <div class="welcome" style="margin-left:150px;">
        <h1 class="display-4">DESTINATION</h1>
    </div>
    <!-- Search bar -->
    <div class="search-container" style="margin-left:150px;">
        <input type="text" id="search" placeholder="Search for places..." class="form-control">
    </div>
    <div class="dashboard">
        <?php foreach ($places as $place): ?>
            <div class="dashboard-item">
                <h2 class="h4"><?= htmlspecialchars($place['name']); ?></h2>
                <img src="<?= htmlspecialchars($place['image']); ?>" class="img-fluid">
                <a href="<?= htmlspecialchars($place['link']); ?>" class="btn btn-success"><?= htmlspecialchars($place['name']); ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function toggleNav() {
        var sidebar = document.getElementById("mySidenav");
        var btn = document.querySelector(".openbtn");
        if (sidebar.style.width === "0px" || sidebar.style.width === "") {
            sidebar.style.width = "250px";
            sidebar.classList.add("opened");
            btn.style.left = "250px";
            btn.innerHTML = "✕";
        } else {
            sidebar.style.width = "0";
            sidebar.classList.remove("opened");
            btn.style.left = "10px";
            btn.innerHTML = "☰";
        }
    }
</script>
<script>
    // Function to filter places based on search input
    function filterPlaces() {
        // Get the search input value
        var searchText = document.getElementById("search").value.toLowerCase();
        
        // Get all dashboard items
        var items = document.getElementsByClassName("dashboard-item");
        
        // Loop through each dashboard item
        for (var i = 0; i < items.length; i++) {
            // Get the name of the place in this item
            var placeName = items[i].getElementsByTagName("h2")[0].innerText.toLowerCase();
            
            // Check if the place name contains the search text
            if (placeName.includes(searchText)) {
                // If it does, display the item
                items[i].style.display = "";
            } else {
                // If not, hide the item
                items[i].style.display = "none";
            }
        }
    }

    // Add event listener to the search input for the 'input' event
    document.getElementById("search").addEventListener("input", filterPlaces);
</script>

</body>
</html>