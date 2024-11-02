<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view your files.");
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

// Fetch files uploaded by the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT filename, filepath, upload_date FROM user_files WHERE user_id='$user_id' ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploaded Files</title>
</head>
<body>
    <h2>My Uploaded Files</h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while($row = $result->fetch_assoc()): ?>
                <li>
                    <a href="<?php echo htmlspecialchars($row['filepath']); ?>" download><?php echo htmlspecialchars($row['filename']); ?></a>
                    (Uploaded on <?php echo $row['upload_date']; ?>)
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have not uploaded any files.</p>
    <?php endif; ?>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
