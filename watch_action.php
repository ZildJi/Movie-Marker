<?php
session_start();
require 'db.php';

// Only logged-in users can use these actions
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$userId  = $_SESSION['user_id'];
$movieId = (int)($_POST['movie_id'] ?? 0);
$action  = $_POST['action'] ?? '';
$back    = ($_POST['back'] ?? '') === 'watchlist' ? 'watchlist.php' : 'index.php';

if ($movieId > 0) {
    if ($action === 'add') {
        $stmt = $pdo->prepare('INSERT IGNORE INTO watchlist (user_id, movie_id) VALUES (?, ?)');
        $stmt->execute([$userId, $movieId]);
        $_SESSION['flash'] = 'Added to your watch list.';
    } elseif ($action === 'toggle') {
        $stmt = $pdo->prepare("UPDATE watchlist SET status = IF(status = 'want', 'watched', 'want') WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        $_SESSION['flash'] = 'Updated.';
    } elseif ($action === 'remove') {
        $stmt = $pdo->prepare('DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?');
        $stmt->execute([$userId, $movieId]);
        $_SESSION['flash'] = 'Removed from your watch list.';
    }
}

header('Location: ' . $back);
exit;