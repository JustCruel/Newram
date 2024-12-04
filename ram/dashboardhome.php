<?php include "sidebar.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .jumbotron {
            margin-left: 140px;
            /* Center horizontally */
            margin-right: 50px;
            margin-top: 10px;

            background-size: 100% 100%;
            color: #fff;

            padding: 20px 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            height: 50vh;
            /* Adjust height as needed */
            width: 80%;
        }

        .jumbotron h1,
        .jumbotron p {
            color: #ffffff;
            /* Green text color for contrast */
            font-family: 'Arial', sans-serif;
            /* Font family */
            text-align: center;
        }

        #sideNavbar {
            transition: all 0.5s ease;
        }

        #sideNavbar {
            transition: all 0.5s ease;
            position: fixed;
            top: 0;
            left: -250px;
            /* Initially hide the side navbar off the screen */
            width: 250px;
            height: 100%;
            background-color: #333;
            /* Background color for side navbar */
            padding-top: 30px;
            /* Adjust padding as needed */
        }

        .navbar-toggler {
            border: none;
            /* Remove border */
            outline: none;
            /* Remove outline */
        }

        @media (max-width: 768px) {
            .announcement-container {
                position: relative;
                /* Reset position */
                width: 100%;
                /* Take full width */
                max-width: none;
                /* Reset max-width */
                margin-top: auto;
                /* Push to bottom */
            }
        }

        /* Adjust announcement container padding for smaller screens */
        @media (max-width: 576px) {
            .announcement-container {
                padding: 10px;
                /* Reduce padding for smaller screens */
            }
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
            background-color: #ddd;
        }



        .content.opened {
            margin-left: 250px;
            /* Margin when sidebar is opened */
        }

        /* CSS for the open/close button */
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

        /* CSS for the announcement container */


        .sidenav {
            position: fixed;
            top: 0;
            left: -250px;
            /* Initially hidden */
            width: 250px;
            height: 100%;
            background-color: #333;
            /* Background color for side navbar */
            transition: left 0.5s ease;
            /* Smooth transition for the sidebar */
        }



        .carousel-item img {
            width: 100%;
            height: 350px;
            /* Adjust height as needed */
            object-fit: cover;
        }

        .carousel-item {
            padding-bottom: 52px;
            /* Adjust the value as needed */
            position: relative;
        }

        .carousel-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(133, 187, 101);
            /* Adjust background color and opacity as needed */
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .custom-btn {
            background-color: rgba(133, 187, 101);
            border-color: rgba(133, 187, 101, 0.7);
            /* Adjust border color if needed */
        }

        .custom-btn:hover {
            background-color: rgba(133, 187, 101, 0.9);
            /* Adjust opacity for hover state */
            border-color: rgba(133, 187, 101, 0.9);
            /* Adjust border color if needed */
        }

        .body {
            background-color: lightgray;
        }

        /* Adjust the carousel item height for smaller screens */
        @media (max-width: 576px) {
            .carousel-item img {
                height: 200px;
                /* Adjust height for smaller screens */
            }
        }

        /* Adjust the announcement container position for smaller screens */
        @media (max-width: 768px) {
            .announcement-container {
                top: 20px;
                /* Adjust top position */
                right: 10px;
                /* Adjust right position */
                width: auto;
                /* Allow width to adjust */
                max-width: 300px;
                /* Limit max width */
            }
        }

        /* Adjust container margin for smaller screens */
        @media (max-width: 992px) {
            .container {
                margin-right: 0;
                /* Remove right margin */
            }
        }

        .carousel-container {
            width: 930px;
            /* Adjust width of the carousel container */
            margin-left: 125px;
        }

        .announcement-container {
            position: relative;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(133, 187, 101);
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            max-width: 1200px;
            /* Adjust as needed */
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .announcement-container .column {
            flex: 1;
            min-width: 300px;
            /* Ensure columns don't get too narrow */
        }

        .sidenav button:hover {
            background-color: #ddd;
        }

        .mt-3 {
            margin-top: 3rem;
            /* Adjust this value as needed */
            color: white;
            /* Gray color */
        }

        .row-md-3 h2 {
            font-family: Arial, sans-serif;
            font-size: 48px;
            font-weight: bold;
            background-color: rgba(133, 187, 101);
            width: 930px;
            color: white;
            /* Yellow green color */
            /* Add any additional styles you want here */
            margin-left: 45px;

        }

        .button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button1 {
            background-color: rgb(87 107 237);
            color: white;
        }

        .button2 {
            background-color: rgb(87 107 237);
            color: white;
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css"> <!-- Your custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f0f0f0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            color: #001f3f;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100vh;
            border-right: 1px solid #e0e0e0;
            /* Added border for sidebar */
        }

        .sidebar img {
            width: 100%;
            /* Make logo responsive */
            height: auto;
            margin-bottom: 20px;
        }

        .button-card {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .button-card:hover {
            background-color: #0056b3;
        }

        .main-content {
            flex: 1;
            margin: 0;
            padding: 20px;
            overflow-y: auto;
            background-color: #ffffff;
            border-left: 1px solid #e0e0e0;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            /* Increased font size for better visibility */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                padding: 15px;
            }

            h2 {
                font-size: 20px;
                /* Smaller heading on smaller screens */
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 150px;
            }

            h2 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <script>
        function showContent(page) {
            const mainContent = document.getElementById('main-content');
            fetch(page)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    mainContent.innerHTML = data; // Inject the content here
                })
                .catch(error => {
                    mainContent.innerHTML = `<h1>Error loading page</h1><p>${error.message}</p>`;
                });
        }
    </script>
</body>

</html>



<!-- Include Bootstrap JS at the end of your document for Bootstrap features -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function toggleNav() {
        var sidebar = document.getElementById("mySidenav");
        var btn = document.querySelector(".openbtn");
        var content = document.querySelector(".content"); // Select the content div
        if (sidebar.style.width === "0px" || sidebar.style.width === "") {
            sidebar.style.width = "250px";
            sidebar.classList.add("opened");
            btn.style.left = "250px";
            btn.innerHTML = "✕";
            content.classList.add("opened"); // Add class to content when sidebar opens
        } else {
            sidebar.style.width = "0";
            sidebar.classList.remove("opened");
            btn.style.left = "10px";
            btn.innerHTML = "☰";
            content.classList.remove("opened"); // Remove class from content when sidebar closes
        }
    }

</script>
<script>
    $(document).ready(function () {
        $('.carousel').carousel({
            interval: 2000
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Initialize the modal
        $('#travelModal').modal({
            show: false // Initialize modal as hidden
        });

        // Function to open the modal when the button is clicked
        $('.btn-primary').click(function () {
            $('#travelModal').modal('show');
        });

        // Function to close the modal when the close button is clicked
        $('#travelModal .close').click(function () {
            $('#travelModal').modal('hide');
        });

        // Function to close the modal when clicking outside of it
        $(document).click(function (event) {
            if ($(event.target).closest('#travelModal').length === 0) {
                $('#travelModal').modal('hide');
            }
        });
    });
</script>
<script>
    // Function to show the modal
    function showModal() {
        $('#travelModal').modal('show');
    }
</script>
<br><br><br><br>
</body>

</html>