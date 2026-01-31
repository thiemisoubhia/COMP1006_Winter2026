<?php
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Sanitize
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName  = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
$position  = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
$skills    = filter_input(INPUT_POST, 'skills', FILTER_SANITIZE_SPECIAL_CHARS);
$email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone     = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$bio       = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_SPECIAL_CHARS);

// Validation
$errors = [];

//require text fields
if ($firstname === null || $firstname === '') {
    $errors[] = "First name is required";
}

if ($lastname === null || $lastname === '') {
    $errors[] = "Last name is required";
}

if ($position === null || $position === '') {
    $errors[] = "Current or last position is required";
}

if ($skills === null || $skills === '') {
    $errors[] = "Skills are required";
}

if ($phone === null || $phone === '') {
    $errors[] = "Phone is required";
}

if ($bio === null || $bio === '') {
    $errors[] = "Short Bio is required";
}

// email validation
if ($email === null || $email === '') {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email must be a valid email address";
}


if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red'>$error</p>";
    }
    echo "<a href='index.php'>Go Back</a>";
    exit;
}

// Insert
$sql = "INSERT INTO users
(first_name, last_name, position, skills, email, phone, bio)
VALUES
(:first_name, :last_name, :position, :skills, :email, :phone, :bio)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':first_name' => $firstName,
    ':last_name'  => $lastName,
    ':position'   => $position,
    ':skills'     => $skills,
    ':email'      => $email,
    ':phone'      => $phone,
    ':bio'        => $bio
]);

echo "<h2>Resume Saved Successfully!</h2>";
