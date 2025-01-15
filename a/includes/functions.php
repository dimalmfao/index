function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function uploadTorrent($file) {
    $targetDir = '../uploads/torrents/';
    $targetFile = $targetDir . basename($file["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid torrent file
    if ($fileType != "torrent") {
        echo "Sorry, only .torrent files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return true;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
    return false;
}

function getTorrents($db) {
    $stmt = $db->prepare("SELECT * FROM torrents ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}