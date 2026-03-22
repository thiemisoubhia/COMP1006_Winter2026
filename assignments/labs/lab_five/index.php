<?php
// Include the database connection so we can interact with the users table
require "includes/connect.php";

require "includes/header.php";

// Array to store validation errors
$errors = [];

// Variable to store a success message if the account is created
$success = "";


// This will store the image path for the database
$imagePath = null;


// Check if the form was submitted using POST
// This ensures the registration logic only runs when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize the username from the form
    // filter_input helps clean user input
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));

    // Retrieve and sanitize the email address
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    // Retrieve password fields (no sanitizing because passwords may contain special characters)
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';



    // Check that a username was entered
    if ($username === '') {
        $errors[] = "Username is required.";
    }

    // Check that an email was entered
    if ($email === '') {
        $errors[] = "Email is required.";
    }
    // Validate the email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    // Check that a password was entered
    if ($password === '') {
        $errors[] = "Password is required.";
    }

    // Check that the confirm password field was filled in
    if ($confirmPassword === '') {
        $errors[] = "Please confirm your password.";
    }

    // Check that both passwords match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Enforce a minimum password length
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }


    // Only check the database if there are no validation errors so far
    if (empty($errors)) {

        // SQL query to check for existing username or email
        $sql = "SELECT id FROM users WHERE username = :username OR email = :email";

        // Prepare the SQL statement using PDO
        $stmt = $pdo->prepare($sql);

        // Bind user inputs to the query parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);

        // Execute the query
        $stmt->execute();

        // If a record is returned, the username or email is already in use
        if ($stmt->fetch()) {
            $errors[] = "That username or email is already in use.";
        }
    }

    // --------------------------------------------------
    // Insert the new user into the database
    // --------------------------------------------------

    // Only insert if there are still no errors
    if (empty($errors)) {

        // Hash the password before storing it in the database
        // This ensures passwords are not stored in plain text
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert the new user
        $sql = "INSERT INTO users (username, email, password, image)
                VALUES (:username, :email, :password, :image)";

        // Prepare the insert statement
        $stmt = $pdo->prepare($sql);

        // Bind the values to the query parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':image_path', $image);

        // Execute the insert query
        $stmt->execute();

        // Set a success message
        $success = "Account created successfully. You can now log in.";
    }

    //check whether a file was uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        //make sure upload completed successfully 
        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "There was a problem uploading your file!";
        } else {
            //only allow a few file types 
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            //detect the real MIME type of the file 
            $detectedType = mime_content_type($_FILES['profile_image']['tmp_name']);
            if (!in_array($detectedType, $allowedTypes, true)) {
                $errors[] = "Only JPG, PNG and WebP allowed";
            } else {
                //build the file name and move it to where we want it to go (uploads)
                //get the file extension 
                $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                //create a unique filename so uploaded files don't overwrite 
                $safeFilename = uniqid('product_', true) . '.' . strtolower($extension);
                //build the full server path where the file will be stored 
                $destination = __DIR__ . '/uploads/' . $safeFilename;
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)) {
                    //save the relative path to the database
                    $imagePath = 'uploads/' . $safeFilename;
                } else {
                    $errors[] = "Image uploaded failed!";
                }
            }
        }
    }
}



?>

<main class="container mt-4">
    <h2>Sign Up</h2>

    <!-- Display validation errors if any exist -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h3>Please fix the following:</h3>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <!-- htmlspecialchars prevents XSS attacks -->
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Display success message if account creation succeeded -->
    <?php if ($success !== ""): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
            <br>
            <!-- Provide a link to the login page -->
            <a href="login.php" class="btn btn-sm btn-success mt-2">Go to Login</a>
        </div>
    <?php endif; ?>

    <!-- Registration form -->
    <form method="post" class="mt-3" enctype="multipart/form-data">

        <!-- Username input -->
        <label for="username" class="form-label">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            class="form-control mb-3"
            value="<?= htmlspecialchars($username ?? ''); ?>"
            required>

        <!-- Email input -->
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control mb-3"
            value="<?= htmlspecialchars($email ?? ''); ?>"
            required>

        <!-- Password input -->
        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-3"
            required>

        <!-- Confirm password input -->
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            class="form-control mb-4"
            required>


        <label for="product_image" class="form-label">Product Image</label>
        <input
            type="file"
            id="product_image"
            name="product_image"
            class="form-control mb-4"
            accept=".jpg,.jpeg,.png,.webp">

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Create Account</button>

        <!-- Link to profile page -->
        <a href="profile.php" class="btn btn-secondary">View Profiles</a>
    </form>
</main>

<?php

require "includes/footer.php";
?>