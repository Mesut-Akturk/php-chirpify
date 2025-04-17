<?php
session_start();
include('db.php');  // Zorg ervoor dat de juiste databaseverbinding wordt gebruikt

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Haal de gebruikersinformatie op uit de database
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (isset($_POST['new_password'])) {
    // Wijzig wachtwoord
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->execute([$newPassword, $username]);
    $message = "Wachtwoord succesvol gewijzigd!";
}

if (isset($_FILES['profile_picture'])) {
    // Upload profielfoto
    $file = $_FILES['profile_picture'];
    $filename = uniqid() . "_" . basename($file['name']);
    $uploadDir = "uploads/" . $filename;

    if (move_uploaded_file($file['tmp_name'], $uploadDir)) {
        $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE username = ?");
        $stmt->execute([$filename, $username]);
        $user['profile_picture'] = $filename;
        $message = "Profielfoto bijgewerkt!";
    } else {
        $error = "Uploaden mislukt!";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Profiel - Chirpify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Chirpify - Profiel</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="profiel.php">Profiel</a></li>
            <li><a href="post.php">Berichten</a></li>
            <li><a href="logout.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>
<main class="profile-container">
    <?php if (isset($message)) echo "<p class='success'>$message</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <div class="profile-info">
        <h2>Welkom, <?= htmlspecialchars($username) ?>!</h2>
        <p>Registratiedatum: <?= $user['created_at'] ?></p>

        <?php if (!empty($user['profile_picture'])): ?>
            <img src="uploads/<?= $user['profile_picture'] ?>" alt="Profielfoto" width="150" style="border-radius: 50%;">
        <?php else: ?>
            <p>Geen profielfoto.</p>
        <?php endif; ?>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <h3>Profielfoto uploaden</h3>
        <input type="file" name="profile_picture" required>
        <button type="submit">Uploaden</button>
    </form>

    <form method="POST">
        <h3>Wachtwoord wijzigen</h3>
        <input type="password" name="new_password" placeholder="Nieuw wachtwoord" required>
        <button type="submit">Wijzigen</button>
    </form>

    <a class="logout-link" href="uitloggen.php">Uitloggen</a>
</main>
</body>
</html>
