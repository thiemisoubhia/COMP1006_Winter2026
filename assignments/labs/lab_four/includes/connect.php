<?php 
$host = "localhost";
$db = "lab_four";
$user = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$db";

//try to connect
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
