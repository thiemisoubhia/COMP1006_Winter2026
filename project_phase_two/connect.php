<?php 
$host = "172.31.22.43"; //hostname
$db = "Thiemi200645138"; //database name
$user = "Thiemi200645138"; //username
$password = "cFUk5GUnRx"; //password

$dsn = "mysql:host=$host;dbname=$db";


try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
