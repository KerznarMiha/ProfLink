<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email or username already exists
    $checkSql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "Username or email already exists. Please try another.";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. <a href='login.php'>Login here</a>.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<h2>Register</h2>
<form action="register.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br> <!-- New Email Field -->

    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>
    
    <button type="submit">Register</button>
</form>

<?php include 'includes/footer.php'; ?>
