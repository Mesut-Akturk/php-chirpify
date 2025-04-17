<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$userStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$userStmt->execute([$_SESSION['username']]);
$user = $userStmt->fetch();

if (!$user) {
    echo "Gebruiker niet gevonden.";
    exit;
}

$user_id = $user['id'];
$post_id = $_POST['post_id'];
$is_like = $_POST['is_like'] === '1' ? 1 : 0;

$checkStmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
$checkStmt->execute([$user_id, $post_id]);
$existing = $checkStmt->fetch();

if ($existing) {

    $updateStmt = $conn->prepare("UPDATE likes SET is_like = ? WHERE user_id = ? AND post_id = ?");
    $updateStmt->execute([$is_like, $user_id, $post_id]);
} else {
   
    $insertStmt = $conn->prepare("INSERT INTO likes (user_id, post_id, is_like) VALUES (?, ?, ?)");
    $insertStmt->execute([$user_id, $post_id, $is_like]);
}

header("Location: index.php");
exit;
