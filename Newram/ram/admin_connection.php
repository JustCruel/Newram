<?php
// admin_connection.php

// Database connection parameters
$host = 'localhost'; // or your server name
$username = 'root'; // your admin database username
$password = ''; // your admin database password
$database = 'tourist'; // your admin database name

// Create a connection
$admin_conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$admin_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>