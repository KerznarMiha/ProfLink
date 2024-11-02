<?php
session_start();
include 'includes/header.php'; // Make sure to create this file or comment out if not needed

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];
    $userId = $_SESSION['user_id'];

    // Define the target directory
    $targetDirectory = 'uploads/';
    $targetFile = $targetDirectory . basename($fileName);

    // Check for upload errors
    if ($fileError !== UPLOAD_ERR_OK) {
        echo "Error during file upload: ";
        switch ($fileError) {
            case UPLOAD_ERR_INI_SIZE:
                echo "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "No file was uploaded.";
                break;
            default:
                echo "Unknown upload error.";
                break;
        }
        exit();
    }

    // Validate file type and size (optional)
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf']; // Adjust based on your needs
    if (!in_array($_FILES['file']['type'], $allowedTypes)) {
        echo "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
        exit();
    }

    if ($fileSize > 2 * 1024 * 1024) { // Limit file size to 2MB
        echo "File size exceeds 2MB limit.";
        exit();
    }

    // Move uploaded file to target directory
    if (move_uploaded_file($fileTmpName, $targetFile)) {
        // Insert file information into the database (optional)
        $sql = "INSERT INTO user_files (user_id, filename, filepath) VALUES ('$userId', '$fileName', '$targetFile')";
        if ($conn->query($sql) === TRUE) {
            echo "File uploaded successfully.";
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "File upload failed.";
    }
}
?>

<h2>Upload a New File</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="file">Choose file to upload:</label>
    <input type="file" name="file" required><br><br>
    <button type="submit">Upload</button>
</form>

<?php include 'includes/footer.php'; ?>
