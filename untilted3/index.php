<?php
// Hier kun je bijvoorbeeld gebruikersinformatie laden (zoals een profiel)
$userName = "ChirpyUser"; // Dit kan uit een database komen
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirpify - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="logo">
        <h1>Chirpify</h1>
    </div>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="profiel.php">Profiel</a></li>
            <li><a href="uitloggen.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="intro">
        <h2>Welkom op Chirpify, <?php echo htmlspecialchars($userName); ?>!</h2>
        <p>De plek waar je snel berichten kunt delen met je vrienden!</p>
    </div>

    <section class="chirps">
        <h3>Laatste berichten:</h3>
        <div class="chirp">
            <p><strong>@<?php echo htmlspecialchars($userName); ?>:</strong> Dit is een voorbeeld van een bericht op Chirpify!</p>
            <small>Geplaatst op 1 april 2025</small>
        </div>
        <div class="chirp">
            <p><strong>@<?php echo htmlspecialchars($userName); ?>:</strong> Welkom op mijn Chirpify-pagina!</p>
            <small>Geplaatst op 31 maart 2025</small>
        </div>
        <!-- Meer berichten kunnen hier dynamisch geladen worden -->
    </section>

    <section class="post-chirp">
        <h3>Wat wil je delen?</h3>
        <form action="post_chirp.php" method="POST">
            <textarea name="chirp_text" placeholder="Schrijf iets..." required></textarea>
            <button type="submit">Plaats bericht</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2025 Chirpify. Alle rechten voorbehouden.</p>
</footer>
</body>
</html>