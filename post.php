<?php
session_start();
include('db.php');


if (!isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

$stmt = $conn->prepare("SELECT posts.id, posts.content, users.username, posts.created_at 
                       FROM posts 
                       JOIN users ON posts.user_id = users.id 
                       ORDER BY posts.created_at DESC");
$stmt->execute();
$posts = $stmt->fetchAll();

if (isset($_POST['delete_post_id'])) {

    $deleteStmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = (SELECT id FROM users WHERE username = ?)");
    $deleteStmt->execute([$_POST['delete_post_id'], $_SESSION['username']]);
    
  
    header("Location: post.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content'])) {
    $content = $_POST['content'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch();

    $insertStmt = $conn->prepare("INSERT INTO posts (content, user_id) VALUES (?, ?)");
    $insertStmt->execute([$content, $user['id']]);


    header("Location: post.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berichten - Chirpify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Chirpify</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="profiel.php">Profiel</a></li>
                <li><a href="logout.php">Uitloggen</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Berichten</h1>

        <form method="POST">
            <textarea name="content" placeholder="Wat wil je delen?" required></textarea>
            <button type="submit">Plaats bericht</button>
        </form>

        <div class="posts">
            <h2>Recent Posts</h2>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <p class="username"><?= htmlspecialchars($post['username']); ?></p>
                    <p class="timestamp"><?= htmlspecialchars($post['created_at']); ?></p>
                    <p><?= nl2br(htmlspecialchars($post['content'])); ?></p>

                    <?php if ($_SESSION['username'] === $post['username']): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_post_id" value="<?= $post['id']; ?>">
                            <button type="submit" onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');">Verwijderen</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
