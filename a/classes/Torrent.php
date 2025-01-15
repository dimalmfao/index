class Torrent {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function uploadTorrent($title, $author, $category, $file) {
        $stmt = $this->db->prepare("INSERT INTO torrents (title, author, category, file_path, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$title, $author, $category, $file]);
    }

    public function getTorrents() {
        $stmt = $this->db->query("SELECT * FROM torrents ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTorrentDetails($id) {
        $stmt = $this->db->prepare("SELECT * FROM torrents WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTorrentFileCount($id) {
        // Assuming the torrent file contains a list of files
        // This is a placeholder for actual implementation
        return rand(1, 10); // Random number for demonstration
    }

    public function getTorrentSize($id) {
        $torrent = $this->getTorrentDetails($id);
        // Placeholder for actual size calculation
        return filesize($torrent['file_path']);
    }

    public function getPeerCount($id) {
        // Placeholder for actual peer count retrieval
        return rand(0, 100); // Random number for demonstration
    }
}