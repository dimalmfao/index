<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
require_once '../classes/Torrent.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    echo '<p>Please <a href="login.php">login</a> to upload torrents.</p>';
    exit;
}

$torrent = new Torrent();
$torrents = $torrent->getAllTorrents();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title><?php echo SITE_NAME; ?> - Home</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="container">
        <h1>Newly Added Torrents</h1>
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search torrents..." required>
            <button type="submit">Search</button>
        </form>
        <table>
            <tr>
                <th>Torrent Name</th>
                <th>Size</th>
                <th>Uploaded By</th>
                <th>Details</th>
            </tr>
            <?php foreach ($torrents as $torrent): ?>
            <tr>
                <td><?php echo htmlspecialchars($torrent['title']); ?></td>
                <td><?php echo htmlspecialchars($torrent['size']); ?></td>
                <td><?php echo htmlspecialchars($torrent['author']); ?></td>
                <td><a href="torrent.php?id=<?php echo $torrent['id']; ?>">View</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>