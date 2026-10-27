<?php
require 'db.php';
$errors = [];
$success = false;
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_]{4,30}$/', $username)) {
        $errors[] = 'Username must be 4-30 letters, numbers, or underscores.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (!$errors) {
        $check = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $check->execute([$username, $email]);
        if ($check->fetch()) {
            $errors[] = 'That username or email is already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
            $insert->execute([$username, $email, $hash]);
            $success = true;
            $username = '';
            $email = '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign up | Movie Marker</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1><a href="index.php">Movie Marker</a></h1>
    <nav>
      <a href="#">Log in</a>
      <a href="register.php">Sign up</a>
    </nav>
  </header>

  <main class="form-page">
    <h2>Create your account</h2>

    <?php if ($success): ?>
      <div class="alert success">Account created! Logging in comes in the next step.</div>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>

    <form method="post">
      <label>Username
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>"
               required minlength="4" maxlength="30" pattern="[A-Za-z0-9_]+">
      </label>
      <label>Email
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
      </label>
      <label>Password (8+ characters)
        <input type="password" name="password" required minlength="8">
      </label>
      <label>Confirm password
        <input type="password" name="confirm" required minlength="8">
      </label>
      <button type="submit">Sign up</button>
    </form>
  </main>
</body>
</html>