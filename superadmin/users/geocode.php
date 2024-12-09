<?php
header('Content-Type: application/json');

// Check if latitude and longitude are set
if (isset($_GET['lat']) && isset($_GET['lon'])) {
    $latitude = $_GET['lat'];
    $longitude = $_GET['lon'];

    // Validate the coordinates
    if (is_numeric($latitude) && is_numeric($longitude)) {
        // Call the Nominatim API for the address
        $url = "https://nominatim.openstreetmap.org/reverse?lat={$latitude}&lon={$longitude}&format=json&addressdetails=1";

        // Set up options to include a User-Agent
        $options = [
            "http" => [
                "header" => "User-Agent: YourAppName/1.0\r\n" // Replace with your app's name and version
            ]
        ];
        $context = stream_context_create($options);

        // Suppress warnings and enable error logging
        $response = @file_get_contents($url, false, $context);

        // Check if the API call was successful
        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (isset($data['display_name'])) {
                echo json_encode(['address' => $data['display_name']]);
            } else {
                echo json_encode(['error' => 'Address not found']);
            }
        } else {
            // Additional error logging for debugging
            $error = error_get_last();
            echo json_encode(['error' => 'Error connecting to the geocoding service: ' . $error['message']]);
        }
    } else {
        echo json_encode(['error' => 'Invalid coordinates']);
    }
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}
?>