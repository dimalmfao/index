<?php
session_start();
require_once '../../config/config.php';
require_once '../../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $torrentFile = $_FILES['torrent_file'];

    // Validate inputs
    if (empty($title) || empty($author) || empty($category) || empty($torrentFile['name'])) {
        $error = "All fields are required.";
    } else {
        // Process the uploaded torrent file
        $targetDir = '../../uploads/torrents/';
        $targetFile = $targetDir . basename($torrentFile['name']);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is a valid torrent file
        if ($fileType != 'torrent') {
            $error = "Only .torrent files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // Do not upload file
        } else {
            if (move_uploaded_file($torrentFile['tmp_name'], $targetFile)) {
                // Save torrent details to the database
                $torrent = new Torrent();
                $torrent->uploadTorrent($title, $author, $category, $targetFile);
                header('Location: ../index.php?success=Torrent uploaded successfully.');
                exit();
            } else {
                $error = "There was an error uploading your file.";
            }
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
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Upload Torrent</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
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