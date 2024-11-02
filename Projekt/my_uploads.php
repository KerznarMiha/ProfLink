<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view and comment on files.");
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
$sql = "SELECT id, filename, filepath, upload_date FROM user_files WHERE user_id='$user_id' ORDER BY upload_date DESC";
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
            <?php while($file = $result->fetch_assoc()): ?>
                <li>
                    <a href="<?php echo htmlspecialchars($file['filepath']); ?>" download><?php echo htmlspecialchars($file['filename']); ?></a>
                    (Uploaded on <?php echo $file['upload_date']; ?>)
                    
                    <!-- Display existing comments and ratings -->
                    <?php
                    $file_id = $file['id'];
                    $comments_sql = "SELECT users.username, comment, rating, comment_date 
                                     FROM file_comments 
                                     JOIN users ON file_comments.user_id = users.id
                                     WHERE file_id='$file_id'
                                     ORDER BY comment_date DESC";
                    $comments_result = $conn->query($comments_sql);
                    ?>
                    
                    <h3>Comments and Ratings:</h3>
                    <?php if ($comments_result->num_rows > 0): ?>
                        <ul>
                            <?php while($comment = $comments_result->fetch_assoc()): ?>
                                <li>
                                    <strong><?php echo htmlspecialchars($comment['username']); ?></strong> 
                                    (Rating: <?php echo htmlspecialchars($comment['rating']); ?>/5):
                                    <?php echo htmlspecialchars($comment['comment']); ?>
                                    <em>on <?php echo $comment['comment_date']; ?></em>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>No comments yet.</p>
                    <?php endif; ?>
                    
                    <!-- Comment and rating form -->
                    <form action="add_comment.php" method="post">
                        <input type="hidden" name="file_id" value="<?php echo $file_id; ?>">
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
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
<!-- Calculate average rating -->
<?php
$rating_sql = "SELECT AVG(rating) as avg_rating FROM file_comments WHERE file_id='$file_id'";
$rating_result = $conn->query($rating_sql);
$avg_rating = $rating_result->fetch_assoc()['avg_rating'];
?>

<h4>Average Rating: <?php echo $avg_rating ? round($avg_rating, 1) : "No ratings yet"; ?>/5</h4>
