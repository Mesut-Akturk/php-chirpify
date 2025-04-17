<?php
session_start();
include('db.php');

$stmt = $conn->prepare("
    SELECT posts.id, posts.content, users.username, posts.created_at,
           SUM(CASE WHEN likes.is_like = 1 THEN 1 ELSE 0 END) AS likes,
           SUM(CASE WHEN likes.is_like = 0 THEN 1 ELSE 0 END) AS dislikes
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    LEFT JOIN likes ON posts.id = likes.post_id
    GROUP BY posts.id
    ORDER BY posts.created_at DESC
");
$stmt->execute();
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Chirpify</title>
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
                <li><a href="post.php">Berichten</a></li>
                <li><a href="logout.php">Uitloggen</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Berichten</h1>
        <div class="posts">
            <h2>Recent Posts</h2>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <p class="username"><?= htmlspecialchars($post['username']); ?></p>
                    <p class="timestamp"><?= htmlspecialchars($post['created_at']); ?></p>
                    <p><?= nl2br(htmlspecialchars($post['content'])); ?></p>

                    <form action="like.php" method="POST" style="display:inline;">
                        <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                        <input type="hidden" name="is_like" value="1">
                        <button type="submit">👍 <?= $post['likes'] ?? 0 ?></button>
                    </form>

                    <form action="like.php" method="POST" style="display:inline;">
                        <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                        <input type="hidden" name="is_like" value="0">
                        <button type="submit">👎 <?= $post['dislikes'] ?? 0 ?></button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
