<?php
require_once "connect.php";
require "parts/auth.php";

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
if ($firstName === null || $firstName === '') {
    $errors[] = "First name is required";
}

if ($lastName === null || $lastName === '') {
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


//picture validation
$picturePath = null;

if (isset($_FILES['picture']) && $_FILES['picture']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "There was an error uploading your picture!";
    } else {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $detectedType = mime_content_type($_FILES['picture']['tmp_name']);
        if (!in_array($detectedType, $allowedTypes, true)) {
            $errors[] = "Only JPG, PNG, and WebP are allowed";
        } else {
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $safeFilename = uniqid('profile_', true) . '.' . strtolower($ext);
            $destination = __DIR__ . '/uploads/' . $safeFilename;
            if (!is_dir(__DIR__ . '/uploads')) mkdir(__DIR__ . '/uploads', 0777, true);
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $destination)) {
                $picturePath = 'uploads/' . $safeFilename;
            } else {
                $errors[] = "Failed to save the picture!";
            }
        }
    }
}


if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red'>$error</p>";
    }
    echo "<a href='index.php'>Go Back</a>";
    exit;
}

// Insert
$sql = "INSERT INTO resumes
            (first_name, last_name, position, skills, email, phone, bio, user_id, picture)
            VALUES (:first_name, :last_name, :position, :skills, :email, :phone, :bio, :user_id, :picture)";


// Prepare the statement
$stmt = $pdo->prepare($sql);

//get the user id
$userId = $_SESSION['user_id'];

//map the named placeholder to the user data
$stmt->bindParam(':first_name', $firstName);
$stmt->bindParam(':last_name', $lastName);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':position', $position);
$stmt->bindParam(':skills', $skills);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':bio', $bio);
$stmt->bindParam(':user_id', $userId);
$stmt->bindParam(':picture', $picturePath);

//execute statement
$stmt->execute();


include "parts/header.php";
?>
<main class="container mt-4 text-center p-5">
    <h2>Resume Saved Successfull</h2>

    <?php echo "<h2>Thank you, " . $firstName . "! Your resume has been added to the system. </h2>" ?>

    <p class="mt-3">
        <a class="btn btn-dark" href="resumes.php">View Resumes</a>
    </p>
</main>