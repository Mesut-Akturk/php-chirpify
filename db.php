<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "chirpify";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    error_log("Verbindingsfout: " . $e->getMessage());
    echo "Er is een probleem met de databaseverbinding. Probeer het later opnieuw.";
    exit;
}
?>

