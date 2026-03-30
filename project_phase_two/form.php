<?php
require "parts/auth.php";

require "connect.php";
require "parts/header.php";
?>

<main class="container mt-4">
    <h2>Create your Resume</h2>
    <h4>Welcome <?= htmlspecialchars($_SESSION['user_name']) ?>!</h4>

    <form method="post" action="save_resume.php">

        <label>First Name</label>
        <input type="text" name="first_name" class="form-control mb-2" required>

        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control mb-2" required>

        <label>Position</label>
        <input type="text" name="position" class="form-control mb-2" required>

        <label>Skills</label>
        <textarea name="skills" class="form-control mb-2" required></textarea>

        <label>Email</label>
        <input type="email" name="email" class="form-control mb-2" required>

        <label>Phone</label>
        <input type="text" name="phone" class="form-control mb-2" required>

        <label>Bio</label>
        <textarea name="bio" class="form-control mb-3" required></textarea>

        <button class="btn btn-success">Save Resume</button>
    </form>

</main>

<?php require "parts/footer.php"; ?>