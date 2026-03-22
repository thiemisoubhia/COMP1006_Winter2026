<?php
// database connection
require "includes/connect.php";

// include header
require "includes/header.php";

// array to store errors
$errors = [];

// success message
$success = "";

// variable to store image path
$imagePath = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // get and sanitize username
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));

    // get and sanitize email
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    // get passwords
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // validation checks
    if ($username === '') {
        $errors[] = "Username is required.";
    }

    if ($email === '') {
        $errors[] = "Email is required.";
    }

    // validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    if ($password === '') {
        $errors[] = "Password is required.";
    }

    if ($confirmPassword === '') {
        $errors[] = "Please confirm your password.";
    }

    // check password match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // check password length
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // check if user already exists
    if (empty($errors)) {

        $sql = "SELECT id FROM users WHERE username = :username OR email = :email";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        if ($stmt->fetch()) {
            $errors[] = "That username or email is already in use.";
        }
    }

    // handle image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "There was a problem uploading your file!";
        } else {
            // allowed image types
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

            // detect file type
            $detectedType = mime_content_type($_FILES['profile_image']['tmp_name']);

            // validate file type
            if (!in_array($detectedType, $allowedTypes, true)) {
                $errors[] = "Only JPG, PNG and WebP allowed";
            } else {
                // create safe filename
                $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('product_', true) . '.' . strtolower($extension);

                // set upload path
                $uploads = __DIR__ . '/uploads/' . $filename;

                // move file to uploads folder
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploads)) {
                    $imagePath = 'uploads/' . $filename;
                } else {
                    $errors[] = "Image uploaded failed!";
                }
            }
        }
    }

    // insert user into database
    if (empty($errors)) {

        // hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, image)
                VALUES (:username, :email, :password, :image)";

        $stmt = $pdo->prepare($sql);

        // bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':image', $imagePath);

        // execute insert
        $stmt->execute();

        $success = "Profile created successfully!!";
    }
}
?>

<main class="container mt-4">
    <h2>Sign Up</h2>

    <!-- display errors -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h3>Please fix the following:</h3>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- display success -->
    <?php if ($success !== ""): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
            <br>
            <a href="profiles.php" class="btn btn-sm btn-success mt-2">Go to Profiles</a>
        </div>
    <?php endif; ?>

    <!-- registration form -->
    <form method="post" class="mt-3" enctype="multipart/form-data">

        <!-- username -->
        <label for="username" class="form-label">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            class="form-control mb-3"
            value="<?= htmlspecialchars($username ?? ''); ?>"
            required>

        <!-- email -->
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control mb-3"
            value="<?= htmlspecialchars($email ?? ''); ?>"
            required>

        <!-- password -->
        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-3"
            required>

        <!-- confirm password -->
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            class="form-control mb-4"
            required>

        <!-- profile image -->
        <label for="profile_image" class="form-label">Profile Image</label>
        <input
            type="file"
            id="profile_image"
            name="profile_image"
            class="form-control mb-4"
            accept=".jpg,.jpeg,.png,.webp">

        <!-- submit button -->
        <button type="submit" class="btn btn-primary">Create Account</button>

        <!-- link to profiles -->
        <a href="profiles.php" class="btn btn-secondary">View Profiles</a>
    </form>
</main>

<?php
// include footer
require "includes/footer.php";
?>