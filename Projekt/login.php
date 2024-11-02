<?php
session_start();
include 'includes/header.php'; // Include the navigation menu and header

// Database connection
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Fetch user based on both username and email
    $sql = "SELECT id, password FROM users WHERE username='$username' AND email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that username and email combination.";
    }
}
?>

<h2>Login</h2>
<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>
    
    <button type="submit">Login</button>
</form>

<?php include 'includes/footer.php'; ?>
