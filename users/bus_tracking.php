<?php
session_start();
include '../config/connection.php';
include 'sidebar.php';

// Initialize default latitude and longitude
$latitude = isset($_SESSION['latitude']) ? $_SESSION['latitude'] : '0'; // Default to 0 if not set
$longitude = isset($_SESSION['longitude']) ? $_SESSION['longitude'] : '0'; // Default to 0 if not set

// Function to update GPS coordinates in session
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['gps_latitude']) && isset($_POST['gps_longitude'])) {
        $_SESSION['latitude'] = $_POST['gps_latitude'];
        $_SESSION['longitude'] = $_POST['gps_longitude'];
        echo "Coordinates updated: Latitude: {$_SESSION['latitude']}, Longitude: {$_SESSION['longitude']}";
        exit; // Exit to prevent further processing of the HTML
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Your custom CSS -->
    <title>GPS Bus Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        #map-container {
            margin-top: 20px;
            display: block;
        }

        #map {
            height: 600px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        h1 {
            color: black;
        }
    </style>
    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>

<body>
    <h1>GPS Bus Location Tracking</h1>

    <!-- Your form section -->
    <div id="form-section">
        <button id="load-map-btn" class="btn btn-primary">Load Map</button>
    </div>

    <!-- Map Container -->
    <div id="map-container" style="display: none; width: 100%; height: 400px;">
        <div id="map" style="width: 100%; height: 100%;"></div>
    </div>

    <script>
        let map, marker; // Declare map and marker variables

        // Function to initialize the Leaflet map
        function initMap() {
            // Create a map centered on the coordinates from the session
            map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add a marker for the current location
            marker = L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map)
                .bindPopup("Current Location")
                .openPopup();

            // Debounce function to limit the number of updates sent to the server
            let lastFetchTime = 0;
            const fetchDelay = 3000; // 3 seconds

            // Update marker position and send GPS updates to the server
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(function (position) {
                    const newLat = position.coords.latitude;
                    const newLon = position.coords.longitude;

                    // Update the marker position
                    marker.setLatLng([newLat, newLon]);
                    map.setView([newLat, newLon]);

                    const now = Date.now();
                    if (now - lastFetchTime > fetchDelay) {
                        // Send updated coordinates to the server using fetch
                        fetch(window.location.href, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `gps_latitude=${newLat}&gps_longitude=${newLon}`
                        })
                            .then(response => response.text())
                            .then(data => {
                                console.log('Location updated:', data);
                            })
                            .catch(error => {
                                console.error('Error updating location:', error);
                            });
                        lastFetchTime = now;
                    }
                }, function (error) {
                    console.error("Error getting location: ", error);
                    alert(`GPS Error: ${error.message}`);
                }, {
                    enableHighAccuracy: true,
                    maximumAge: 0,
                    timeout: 5000
                });
            }
        }

        // Function to show the map
        function showMap() {
            document.getElementById('form-section').style.display = 'none';
            document.getElementById('map-container').style.display = 'block';
            initMap(); // Initialize the map
        }

        // Event listener for the button to load the map
        document.getElementById('load-map-btn').addEventListener('click', function () {
            showMap(); // Show the map when button is clicked
        });

        // Optional: Automatically load the map when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            // initMap(); // Uncomment if you want the map to load automatically
        });
    </script>
</body>

</html>