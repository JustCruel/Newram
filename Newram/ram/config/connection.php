<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname ="tourist";

if (!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)) {


			die("failed to connect!");

	}



  ?>