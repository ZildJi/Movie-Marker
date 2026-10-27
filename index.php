<?php
session_start();
require 'db.php';

$stmt = $pdo->query('SELECT * FROM movies ORDER BY release_year DESC');
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$saved = [];
if (isset($_SESSION['user_id'])) {
    $s = $pdo->prepare('SELECT movie_id FROM watchlist WHERE user_id = ?');
    $s->execute([$_SESSION['user_id']]);
    $saved = array_map('intval', $s->fetchAll(PDO::FETCH_COLUMN));
}

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Movie Marker</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1><a href="index.php">Movie Marker</a></h1>
    <nav>
      <?php if (isset($_SESSION['user_id'])): ?>
        <span>Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="watchlist.php">My Watch List</a>
        <a href="logout.php">Log out</a>
      <?php else: ?>
        <a href="login.php">Log in</a>
        <a href="register.php">Sign up</a>
      <?php endif; ?>
    </nav>
  </header>

  <main>
    <section class="hero">
      <h2>Find your next movie.</h2>
      <p>Browse freely. Log in to save movies and build your watch list.</p>
    </section>

    <section class="movies">
      <?php if ($flash): ?>
        <div class="alert success"><?= htmlspecialchars($flash) ?></div>
      <?php endif; ?>

      <h2>Browse movies</h2>
      <div class="grid">
        <?php foreach ($movies as $movie): ?>
          <article class="card">
            <h3><?= htmlspecialchars($movie['title']) ?></h3>
            <p class="meta"><?= htmlspecialchars($movie['genre']) ?> | <?= (int)$movie['release_year'] ?></p>
            <p><?= htmlspecialchars($movie['description']) ?></p>

            <?php if (!isset($_SESSION['user_id'])): ?>
              <a class="btn-link" href="login.php">Log in to save</a>
            <?php elseif (in_array((int)$movie['id'], $saved, true)): ?>
              <span class="saved">In your watch list</span>
            <?php else: ?>
              <form method="post" action="watch_action.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="movie_id" value="<?= (int)$movie['id'] ?>">
                <button type="submit" class="btn">+ Watch later</button>
              </form>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
</body>
</html>