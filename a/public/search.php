<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

if ($searchTerm) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $stmt = $conn->prepare("SELECT * FROM torrents WHERE title LIKE :searchTerm ORDER BY created_at DESC");
    $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
    $torrents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $torrents = [];
}

include '../templates/header.php';
?>

<div class="container">
    <h1>Search Results</h1>
    <form method="GET" action="search.php">
        <input type="text" name="query" placeholder="Search for torrents..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($torrents): ?>
        <ul>
            <?php foreach ($torrents as $torrent): ?>
                <li>
                    <a href="torrent.php?id=<?php echo $torrent['id']; ?>"><?php echo htmlspecialchars($torrent['title']); ?></a>
                    - <?php echo htmlspecialchars($torrent['size']); ?> - <?php echo htmlspecialchars($torrent['author']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No torrents found matching your search.</p>
    <?php endif; ?>
</div>

<?php include '../templates/footer.php'; ?>