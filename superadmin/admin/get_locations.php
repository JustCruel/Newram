<?php
include '../config/connection.php';

// Function to fetch data from API
function fetchData($url)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ],
    ]);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        echo 'cURL Error: ' . curl_error($curl);
        return null;
    }

    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        echo 'API Error: Received HTTP code ' . $httpCode;
        return null;
    }

    curl_close($curl);
    return json_decode($response, true);
}

// Fetch data from PSGC API
$provinces = fetchData('https://psgc.gitlab.io/api/provinces');
$municipalities = fetchData('https://psgc.gitlab.io/api/municipalities');
$barangays = fetchData('https://psgc.gitlab.io/api/barangays');

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $province_id = isset($_POST['province_id']) ? $_POST['province_id'] : null;
    $municipality_id = isset($_POST['municipality_id']) ? $_POST['municipality_id'] : null;
    $barangay_id = isset($_POST['barangay_id']) ? $_POST['barangay_id'] : null;

    $response = [];

    // Fetch province name
    if ($province_id && isset($provinces['data'])) {
        foreach ($provinces['data'] as $province) {
            if ($province['id'] == $province_id) {
                $response['province'] = $province['name'];
                break;
            }
        }
        if (!isset($response['province'])) {
            $response['province'] = null; // Explicitly set to null if not found
        }
    }

    // Fetch municipality name
    if ($municipality_id && isset($municipalities['data'])) {
        foreach ($municipalities['data'] as $municipality) {
            if ($municipality['id'] == $municipality_id) {
                $response['municipality'] = $municipality['name'];
                break;
            }
        }
        if (!isset($response['municipality'])) {
            $response['municipality'] = null; // Explicitly set to null if not found
        }
    }

    // Fetch barangay name
    if ($barangay_id && isset($barangays['data'])) {
        foreach ($barangays['data'] as $barangay) {
            if ($barangay['id'] == $barangay_id) {
                $response['barangay'] = $barangay['name'];
                break;
            }
        }
        if (!isset($response['barangay'])) {
            $response['barangay'] = null; // Explicitly set to null if not found
        }
    }

    // Return JSON response
    echo json_encode($response);
    exit; // Ensure to exit after outputting the response
}
?>