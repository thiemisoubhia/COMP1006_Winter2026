<?php
require_once "connect.php"; // connect to database
include "parts/header.php"; // header section

// get id from URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    // if no id, go back to resumes list
    header("Location: resumes.php");
    exit;
}

// get resume from DB
$sql = "SELECT * FROM resumes WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
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

    // update resume
    $sqlUpdate = "
        UPDATE resumes
        SET first_name = :first_name,
            last_name = :last_name,
            position = :position,
            skills = :skills,
            email = :email,
            phone = :phone,
            bio = :bio
        WHERE id = :id
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
        ':id'         => $id
    ]);

    // go back to resumes page
    header("Location: resumes.php");
    exit;
}
?>

<main class="container mt-4">

<div id="forms">
    <h2>Editing your <img src="images/logo.png" alt="" width="150px"></h2>

    <form method="POST">

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

        <!--bio -->
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3"><?= htmlspecialchars($resume['bio']) ?></textarea>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-dark">Update</button>
        <a href="resumes.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

</main>
