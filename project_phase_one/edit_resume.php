<?php
require_once "connect.php";
include "parts/header.php";

//check id
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    //return to resume when id not found
    header("Location: resumes.php");
    exit;
}
?>


<main class="container mt-4">

<div id="forms">
    <h2>Editing your <img src="images/logo.png" alt="" width="150px"></h2>

    <form method="POST">

        <div class="row mb-3">
            <div class="col">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text"
                       class="form-control"
                       id="firstName"
                       name="first_name"
                       value="<?= htmlspecialchars($resume['first_name']) ?>"
                       required>
            </div>

            <div class="col">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text"
                       class="form-control"
                       id="lastName"
                       name="last_name"
                       value="<?= htmlspecialchars($resume['last_name']) ?>"
                       required>
            </div>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Current Position</label>
            <input type="text"
                   class="form-control"
                   id="position"
                   name="position"
                   value="<?= htmlspecialchars($resume['position']) ?>"
                   required>
        </div>

        <div class="mb-3">
            <label for="skills" class="form-label">Skills (comma-separated)</label>
            <input type="text"
                   class="form-control"
                   id="skills"
                   name="skills"
                   value="<?= htmlspecialchars($resume['skills']) ?>">
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       value="<?= htmlspecialchars($resume['email']) ?>"
                       required>
            </div>

            <div class="col">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel"
                       class="form-control"
                       id="phone"
                       name="phone"
                       value="<?= htmlspecialchars($resume['phone']) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="bio" class="form-label">Short Bio</label>
            <textarea class="form-control"
                      id="bio"
                      rows="3"
                      name="bio"><?= htmlspecialchars($resume['bio']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-dark">Update</button>
        <a href="resumes.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

</main>
