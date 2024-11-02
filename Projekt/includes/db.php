<?php
// Database configuration
$host = 'localhost';
$dbname = 'registration_db';
$user = 'root';
$pass = '';

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
