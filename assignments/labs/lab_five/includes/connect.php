<?php 
$host = "localhost"; //hostname
$db = "lab05"; //database name
$user = "root"; //username
$password = ""; //password

$dsn = "mysql:host=$host;dbname=$db";


try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
