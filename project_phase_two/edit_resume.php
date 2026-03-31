<?php
require_once "connect.php"; // connect to database
require "parts/auth.php";    // check user login
include "parts/header.php";  // header section

// get id from URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    // if no id, go back to resumes list
    header("Location: resumes.php");
    exit;
}

// get resume from DB
$sql = "SELECT * FROM resumes WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id' => $id,
    ':user_id' => $_SESSION['user_id']
]);
$resume = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resume) {
    // if resume not found, go back
    header("Location: resumes.php");
    exit;
}

// if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // get form values
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $position   = trim($_POST['position']);
    $skills     = trim($_POST['skills']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $bio        = trim($_POST['bio']);

    // handle picture upload
    $picturePath = $resume['picture']; // keep existing picture by default
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
            $error = "There was an error uploading the picture!";
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            $detectedType = mime_content_type($_FILES['picture']['tmp_name']);
            if (!in_array($detectedType, $allowedTypes, true)) {
                $error = "Only JPG, PNG, and WebP files are allowed!";
            } else {
                $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                $safeFilename = uniqid('profile_', true) . '.' . strtolower($ext);
                $destination = __DIR__ . '/uploads/' . $safeFilename;

                // create uploads folder if it doesn't exist
                if (!is_dir(__DIR__ . '/uploads')) mkdir(__DIR__ . '/uploads', 0777, true);

                if (move_uploaded_file($_FILES['picture']['tmp_name'], $destination)) {
                    $picturePath = 'uploads/' . $safeFilename;
                    // optionally, delete old picture
                    if ($resume['picture'] && file_exists(__DIR__ . '/' . $resume['picture'])) {
                        unlink(__DIR__ . '/' . $resume['picture']);
                    }
                } else {
                    $error = "Failed to save the picture!";
                }
            }
        }
    }

    // update resume in database
    $sqlUpdate = "
        UPDATE resumes
        SET first_name = :first_name,
            last_name  = :last_name,
            position   = :position,
            skills     = :skills,
            email      = :email,
            phone      = :phone,
            bio        = :bio,
            picture    = :picture
        WHERE id = :id AND user_id = :user_id
    ";

    $stmt = $pdo->prepare($sqlUpdate);
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name'  => $last_name,
        ':position'   => $position,
        ':skills'     => $skills,
        ':email'      => $email,
        ':phone'      => $phone,
        ':bio'        => $bio,
        ':picture'    => $picturePath,
        ':id'         => $id,
        ':user_id'    => $_SESSION['user_id']
    ]);

    // redirect back to resumes page
    header("Location: resumes.php");
    exit;
}
?>

<main class="container mt-4">

<div id="forms">
    <h2>Editing your <img src="images/logo.png" alt="" width="150px"></h2>

    <form method="POST" enctype="multipart/form-data">

        <!-- First & Last Name -->
        <div class="row mb-3">
            <div class="col">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="first_name"
                       value="<?= htmlspecialchars($resume['first_name']) ?>" required>
            </div>

            <div class="col">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="last_name"
                       value="<?= htmlspecialchars($resume['last_name']) ?>" required>
            </div>
        </div>

        <!-- Position -->
        <div class="mb-3">
            <label for="position" class="form-label">Current Position</label>
            <input type="text" class="form-control" id="position" name="position"
                   value="<?= htmlspecialchars($resume['position']) ?>" required>
        </div>

        <!-- Skills -->
        <div class="mb-3">
            <label for="skills" class="form-label">Skills</label>
            <input type="text" class="form-control" id="skills" name="skills"
                   value="<?= htmlspecialchars($resume['skills']) ?>">
        </div>

        <!-- Email & Phone -->
        <div class="row mb-3">
            <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= htmlspecialchars($resume['email']) ?>" required>
            </div>

            <div class="col">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                       value="<?= htmlspecialchars($resume['phone']) ?>">
            </div>
        </div>

        <!-- Bio -->
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3"><?= htmlspecialchars($resume['bio']) ?></textarea>
        </div>

        <!-- Profile Picture -->
        <div class="mb-3">
            <label for="picture" class="form-label">Profile Picture</label>
            <?php if ($resume['picture']): ?>
                <div class="mb-2">
                    <img src="<?= htmlspecialchars($resume['picture']) ?>" width="100" height="100" alt="Current Picture">
                </div>
            <?php endif; ?>
            <input type="file" name="picture" class="form-control" accept=".jpg,.jpeg,.png,.webp">
            <small class="text-muted">Upload a new picture to replace the current one.</small>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-dark">Update</button>
        <a href="resumes.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

</main>