<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: posts.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom bij Chirpify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .home-container {
            background-color: white;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
        }

        .home-container h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .home-container p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
        }

        .home-container a {
            display: inline-block;
            margin: 10px 15px;
            padding: 12px 24px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .home-container a:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
    <div class="home-container">
        <h1>Welkom bij Chirpify 🐦</h1>
        <p>De plek om korte berichten te delen met de wereld.</p>
        <a href="login.php">Inloggen</a>
        <a href="register
