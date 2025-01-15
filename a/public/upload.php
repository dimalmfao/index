<?php
session_start();
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../classes/Torrent.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $file = $_FILES['torrent_file'];

    // Validate inputs
    if (empty($title) || empty($author) || empty($category) || empty($file['name'])) {
        $error = "All fields are required.";
    } else {
        // Process the uploaded file
        $torrent = new Torrent();
        $uploadResult = $torrent->uploadTorrent($file, $title, $author, $category);

        if ($uploadResult) {
            header('Location: index.php?success=Torrent uploaded successfully.');
            exit();
        } else {
            $error = "Failed to upload torrent.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Torrent</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Upload Torrent</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" required>
            <label for="author">Author:</label>
            <input type="text" name="author" required>
            <label for="category">Category:</label>
            <input type="text" name="category" required>
            <label for="torrent_file">Torrent File:</label>
            <input type="file" name="torrent_file" accept=".torrent" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>