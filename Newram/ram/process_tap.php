<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'tourist'); // Adjust credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simulated RFID tap data (in practice, this will come from the RFID reader)
$userId = $_POST['user_id']; // Assume user ID is obtained from the session or RFID scan
$latitude = $_POST['latitude']; // GPS coordinates from the bus
$longitude = $_POST['longitude']; // GPS coordinates from the bus

// Check the last tap for the user
$query = "SELECT tap_type FROM rfid_taps WHERE user_id = '$userId' ORDER BY tap_time DESC LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Get the last tap type
    $lastTap = $result->fetch_assoc();

    if ($lastTap['tap_type'] === 'start') {
        // If last tap was "start", this tap is "end"
        $tapType = 'end';
    } else {
        // If last tap was "end" or if it's the user's first tap, this is a new "start"
        $tapType = 'start';
    }
} else {
    // No previous taps, so this is the first "start" tap
    $tapType = 'start';
}

// Insert the RFID tap data into the database
$query = "INSERT INTO rfid_taps (user_id, latitude, longitude, tap_type)
          VALUES ('$userId', '$latitude', '$longitude', '$tapType')";
$conn->query($query);

// Function to calculate Haversine distance between two GPS coordinates
function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // Radius in meters

    // Convert degrees to radians
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Haversine formula
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;
    $a = sin($dlat / 2) * sin($dlat / 2) +
        cos($lat1) * cos($lat2) *
        sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;

    return $distance; // Distance in meters
}

// If the tap type is "end", calculate the distance from the "start" tap
if ($tapType === 'end') {
    // Get the last "start" tap for the user
    $query = "SELECT latitude, longitude FROM rfid_taps
              WHERE user_id = '$userId' AND tap_type = 'start'
              ORDER BY tap_time DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Get the start tap coordinates
        $row = $result->fetch_assoc();
        $startLat = $row['latitude'];
        $startLon = $row['longitude'];

        // Calculate distance between the start and end points
        $distance = haversineDistance($startLat, $startLon, $latitude, $longitude);

        // Display the distance in kilometers
        echo "Total Distance: " . number_format($distance / 1000, 2) . " km";

        // Calculate fare based on distance (example: ₱10 per kilometer)
        $ratePerKm = 10;
        $fare = ($distance / 1000) * $ratePerKm;
        echo "<br>Total Fare: ₱" . number_format($fare, 2);
    } else {
        echo "No start tap found for user ID $userId.";
    }
} else {
    echo "Start tap recorded. Waiting for end tap.";
}

$conn->close();
?>