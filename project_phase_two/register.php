<?php
session_start();
require "connect.php";
require "parts/header.php";

//initialize errors and success message
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // reference: https://www.youtube.com/watch?v=iAPcf8vD85E
    //Google recatcha secret key
    $recaptchaSecret = "6LeWXp0sAAAAACpxpNu3wPGmPxfnIP9RRq2XkFDQ";
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    //verify recatcha
    // $verify = file_get_contents(
    //     "https://www.google.com/recaptcha/api/siteverify?secret=" 
    //     . $recaptchaSecret . "&response=" . $recaptchaResponse
    // );
    // $captchaSuccess = json_decode($verify);

    // if (!$captchaSuccess->success) {
    //     $errors[] = "Please verify that you are not a robot.";
    // }

    //validate input
    $firstName = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $lastName  = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $email     = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password  = $_POST['password'] ?? '';

    if ($firstName === '') $errors[] = "First name is required.";
    if ($lastName === '')  $errors[] = "Last name is required.";

    if ($email === '') {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if ($password === '') {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }

    //check email
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = "This email is already registered.";
        }
    }

    //if no errors, insert to the table users
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password)
            VALUES (:first, :last, :email, :password)
        ");
        // prepare
        $stmt = $pdo->prepare($sql);

        // bind params
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name',  $lastName);
        $stmt->bindParam(':email',      $email);
        $stmt->bindParam(':password', $hashedPassword);

        // execute
        $stmt->execute();

        $success = "Account created successfully! You can now login.";
    }
}
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Register</h2>

            <!-- Display errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Display success message -->
            <?php if ($success !== ""): ?>
                <div class="alert alert-success text-center">
                    <?= $success ?>
                    <br><a href="login.php" class="btn btn-success mt-2">Login</a>
                </div>
            <?php endif; ?>

            <!-- Registration form -->
            <form method="post" class="mt-3">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small class="form-text text-muted">Password must be at least 8 characters.</small>
                </div>

                <!-- reCAPTCHA -->
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="6LeWXp0sAAAAAPRmPwKeeymbatciThEcNSSYFFGC"></div>
                </div>

                <button type="submit" class="btn btn-dark w-100">Register</button>
                <a href="login.php" class="btn btn-secondary w-100 mt-2">Already have an account? Login</a>
            </form>
        </div>
    </div>
</main>


<?php require "parts/footer.php"; ?>