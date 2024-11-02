<?php
session_start();
include 'includes/header.php'; // Include the navigation menu and header

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, filename, filepath, upload_date FROM user_files WHERE user_id='$user_id' ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>

<h2>My Uploaded Files</h2>
<?php if ($result->num_rows > 0): ?>
    <ul>
        <?php while($file = $result->fetch_assoc()): ?>
            <li>
                <a href="<?php echo htmlspecialchars($file['filepath']); ?>" download><?php echo htmlspecialchars($file['filename']); ?></a>
                (Uploaded on <?php echo $file['upload_date']; ?>)

                <!-- Comment and rating form -->
                <form action="add_comment.php" method="post">
                    <input type="hidden" name="file_id" value="<?php echo $file['id']; ?>">
                    <label for="rating">Rating (1-5):</label>
                    <select name="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select><br><br>
                    <label for="comment">Comment:</label><br>
                    <textarea name="comment" rows="4" cols="50" required></textarea><br><br>
                    <button type="submit">Submit Comment</button>
                </form>
            </li>
            <hr>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>You have not uploaded any files.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
