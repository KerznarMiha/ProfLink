<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to comment.");
}

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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $file_id = $conn->real_escape_string($_POST['file_id']);
    $rating = intval($_POST['rating']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // Insert comment and rating into the database
    $sql = "INSERT INTO file_comments (file_id, user_id, comment, rating) VALUES ('$file_id', '$user_id', '$comment', '$rating')";

    if ($conn->query($sql) === TRUE) {
        echo "Comment and rating added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Redirect back to the file page
header("Location: my_files.php");
exit();
?>
