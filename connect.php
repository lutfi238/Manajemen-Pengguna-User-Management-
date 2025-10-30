<?php
// Set timezone
date_default_timezone_set('Asia/Jakarta');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uts_web";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Set MySQL timezone to match PHP
$conn->query("SET time_zone = '+07:00'");

// echo "Connected successfully <br>";

?>