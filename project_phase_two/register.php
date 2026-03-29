<?php
session_start();
require "connect.php";
require "parts/header.php";

// store errors and success message
$errors = [];
$success = "";

// run only if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // secret key api 6LeWXp0sAAAAACpxpNu3wPGmPxfnIP9RRq2XkFDQ
    $recaptchaSecret = "6LeWXp0sAAAAACpxpNu3wPGmPxfnIP9RRq2XkFDQ";
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    $verify = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret="
        . $recaptchaSecret . "&response=" . $recaptchaResponse
    );

    $captchaSuccess = json_decode($verify);

    if (!$captchaSuccess->success) {
        $errors[] = "Please verify that you are not a robot.";
    }


    $firstName = trim(filter_input(INPUT_POST,'first_name',FILTER_SANITIZE_SPECIAL_CHARS));
    $lastName  = trim(filter_input(INPUT_POST,'last_name',FILTER_SANITIZE_SPECIAL_CHARS));
    $email     = trim(filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL));
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


    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($stmt->fetch()) {
            $errors[] = "This email is already registered.";
        }
    }


    if (empty($errors)) {

        // hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password)
            VALUES (:first, :last, :email, :password)
        ");

        $stmt->execute([
            ':first' => $firstName,
            ':last' => $lastName,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        $success = "Account created successfully! You can now login.";
    }
}
?>

<main class="container mt-4">

<h2>Register</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($success !== ""): ?>
    <div class="alert alert-success">
        <?= $success ?>
        <br><a href="login.php" class="btn btn-success mt-2">Login</a>
    </div>
<?php endif; ?>

</main>

<?php require "parts/footer.php"; ?>