<?php
session_start();

function login($username, $password) {
    global $pdo; // Assuming $pdo is defined in your database connection file

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (isLoggedIn()) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}
?>