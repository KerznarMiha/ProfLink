<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
?>

<h2>Welcome to Your Dashboard</h2>
<p>From here, you can upload files, view your uploaded files, and add comments and ratings.</p>
<ul>
    <li><a href="upload.php">Upload a New File</a></li>
    <li><a href="my_files.php">View My Files</a></li>
</ul>

<?php include 'includes/footer.php'; ?>
