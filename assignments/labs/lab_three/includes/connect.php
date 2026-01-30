<?php
//make PHP strict
declare(strict_types=1);

$host = "localhost"; //hostname
$db = "lab_three"; //database name
$user = "root"; //username
$password = ""; //password

//points to the database
$dsn = "mysql:host=$host;dbname=$db";

//try to connect and show the error if not connected
try{
    $pdo = new PDO ($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo"<p>CONNECTED!!</p>";

}catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}