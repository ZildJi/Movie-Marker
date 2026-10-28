<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT m.*, w.status FROM watchlist w JOIN movies m ON m.id = w.movie_id WHERE w.user_id = ? ORDER BY w.created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Watch List | Movie Marker</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1><a href="index.php">Movie Marker</a></h1>
    <nav>
      <span>Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
      <a href="index.php">Browse</a>
      <a href="logout.php">Log out</a>
    </nav>
  </header>

  <main class="movies">
    <h2>My Watch List</h2>

    <?php if ($flash): ?>
      <div class="alert success"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <?php if (!$items): ?>
      <p>Your list is empty. <a href="index.php">Browse movies</a> and tap "+ Watch later".</p>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($items as $m): ?>
          <article class="card <?= $m['status'] === 'watched' ? 'watched' : '' ?>">
            <h3><?= htmlspecialchars($m['title']) ?></h3>
            <?php if (!empty($m['poster'])): ?>
  <img src="images/<?= htmlspecialchars($m['poster']) ?>"
       alt="Poster of <?= htmlspecialchars($m['title']) ?>">
<?php endif; ?>
            <p class="meta"><?= htmlspecialchars($m['genre']) ?> | <?= (int)$m['release_year'] ?></p>
            <p class="meta">Status: <?= $m['status'] === 'watched' ? 'Watched' : 'Want to watch' ?></p>

            <form method="post" action="watch_action.php" class="inline">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="back" value="watchlist">
              <input type="hidden" name="movie_id" value="<?= (int)$m['id'] ?>">
              <button type="submit" class="btn">
                <?= $m['status'] === 'watched' ? 'Mark as not watched' : 'Mark as watched' ?>
              </button>
            </form>

            <form method="post" action="watch_action.php" class="inline"
                  onsubmit="return confirm('Remove this movie from your list?')">
              <input type="hidden" name="action" value="remove">
              <input type="hidden" name="back" value="watchlist">
              <input type="hidden" name="movie_id" value="<?= (int)$m['id'] ?>">
              <button type="submit" class="btn danger">Remove</button>
            </form>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>