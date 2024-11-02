<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to upload files.");
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

// Check if a file was uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $user_id = $_SESSION['user_id']; // The logged-in user ID
    $file = $_FILES['file'];

    // Directory to store uploads
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
    }

    // File properties
    $filename = basename($file['name']);
    $target_file = $upload_dir . uniqid() . '_' . $filename; // Unique filename to avoid overwriting

    // Check file size (5MB max)
    if ($file['size'] > 5 * 1024 * 1024) {
        die("File is too large. Maximum file size is 5MB.");
    }

    // Allow only certain file types (e.g., images and PDFs)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
    if (!in_array($file['type'], $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, GIF, and PDF files are allowed.");
    }

    // Move file to the upload directory
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Insert file info into the database
        $sql = "INSERT INTO user_files (user_id, filename, filepath) VALUES ('$user_id', '$filename', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            echo "File uploaded successfully!";
        } else {
            echo "Error storing file information: " . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file was uploaded.";
}

// Close the connection
$conn->close();
?>
