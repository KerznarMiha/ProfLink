<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$dbname = 'registration_db'; // Database name (must match the one used in registration)
$user = 'root';              // Database username
$pass = '';                  // Database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Not escaping here, as we don’t store it directly in the database

    // Retrieve the user from the database by email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo "Login successful! Welcome, " . htmlspecialchars($user['username']) . "!";
            // Here you can redirect the user to another page or start a session
            // header("Location: welcome.php"); // Uncomment to redirect to a welcome page
            // exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }
}

// Close the connection
$conn->close();
?>
