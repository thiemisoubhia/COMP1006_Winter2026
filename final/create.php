<?php
require "connect.php";
require "includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Sanitize
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);

// Validation
$errors = [];

//require title
if ($title === null || $title === '') {
    $errors[] = "Title is required";
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
    echo "<a href='gallery.php'>Go Back</a>";
    exit;
}

// Insert
$sql = "INSERT INTO gallery
            (title, user_id, picture)
            VALUES (:title, :user_id, :picture)";


// Prepare the statement
$stmt = $pdo->prepare($sql);

//get the user id
$userId = $_SESSION['user_id'];

//map the named placeholder to the user data
$stmt->bindParam(':title', $title);
$stmt->bindParam(':user_id', $userId);
$stmt->bindParam(':picture', $picturePath);

//execute statement
$stmt->execute();


include "includes/header.php";
?>
<main class="container mt-4 text-center p-5">
    <h2>Image Saved Successfull!!!</h2>

    <?php echo "<h2>Thank you! Your image has been added to the Gallery. </h2>" ?>

    <p class="mt-3">
        <a class="btn btn-dark" href="gallery.php">View Gallery</a>
    </p>
</main>