<?php
require_once '../includes/functions.php';
require_once '../classes/Torrent.php';

if (!isset($_GET['id'])) {
    die('Torrent ID not specified.');
}

$torrentId = intval($_GET['id']);
$torrent = new Torrent();
$torrentDetails = $torrent->getTorrentById($torrentId);

if (!$torrentDetails) {
    die('Torrent not found.');
}

$fileCount = count($torrentDetails['files']);
$torrentSize = formatSize($torrentDetails['size']);
$peersCount = $torrent->getPeersCount($torrentId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($torrentDetails['title']); ?> - Torrent Tracker</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    
    <div class="container">
        <h1><?php echo htmlspecialchars($torrentDetails['title']); ?></h1>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($torrentDetails['author']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($torrentDetails['category']); ?></p>
        <p><strong>File Count:</strong> <?php echo $fileCount; ?></p>
        <p><strong>Torrent Size:</strong> <?php echo $torrentSize; ?></p>
        <p><strong>Peers:</strong> <?php echo $peersCount; ?></p>
        
        <h2>Files:</h2>
        <ul>
            <?php foreach ($torrentDetails['files'] as $file): ?>
                <li><?php echo htmlspecialchars($file); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>