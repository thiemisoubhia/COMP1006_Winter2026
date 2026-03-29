<!-- header part -->
<?php require "parts/header.php"; ?>


<div class="container mt-5">
    <h2>Create Account</h2>

    <!-- form to create new user -->
    <form method="POST" action="register_process.php">
        <input name="first_name" class="form-control mb-2" placeholder="First name" required>
        <input name="last_name" class="form-control mb-2" placeholder="Last name" required>
        <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
        <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>

        <button class="btn btn-dark">Register</button>
    </form>
</div>