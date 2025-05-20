<?php 

$dsn = "mysql:host=localhost;dbname=gestion_joueurs";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   
} catch (PDOException $e) {
    die("Error : ".$e->getMessage());
}