<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Tap Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #4CAF50;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input,
        select,
        button {
            padding: 10px;
            margin: 5px 0 20px;
            width: 100%;
        }
    </style>
    <script>
        // Example data simulating user ID to GPS coordinates mapping
        const userLocations = {
            1: { latitude: 14.5995, longitude: 120.9842 }, // Example coordinates for user ID 1
            2: { latitude: 14.6000, longitude: 120.9850 }, // Example coordinates for user ID 2
            // Add more user IDs and coordinates as needed
        };

        function onScanUserId() {
            const userIdInput = document.getElementById('user_id');
            const userId = userIdInput.value;

            // Check if the user ID exists in our example data
            if (userLocations[userId]) {
                const { latitude, longitude } = userLocations[userId];
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            } else {
                // If user ID not found, clear the latitude and longitude fields
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
                alert('User ID not found!');
            }
        }
    </script>
</head>

<body>
    <h1>RFID Tap Management System</h1>

    <form action="process_tap.php" method="POST">
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" required placeholder="Enter your User ID"
            oninput="onScanUserId()">

        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" required placeholder="Enter GPS Latitude" readonly>

        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" required placeholder="Enter GPS Longitude" readonly>

        <button type="submit">Submit RFID Tap</button>
    </form>
</body>

</html>