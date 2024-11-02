<?php
// Database configuration
$host = 'localhost';     // Database host (usually localhost)
$dbname = 'registration_db'; // Database name
$user = 'root';          // Database username
$pass = '';              // Database password (leave blank for default on localhost)

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch input
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the email or username already exists
    $checkUserQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        echo "Username or email already taken!";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user data into the database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>
