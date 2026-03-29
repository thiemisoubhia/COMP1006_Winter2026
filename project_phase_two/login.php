<?php
//start a session to manage user login
session_start();

//require parts
//database connection
require "includes/connect.php";
require "includes/header.php";

//errorMessage messages
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usernameOrEmail === '' || $password === '') {
        $errorMessage = "Username/email and password are required.";
    } else {
        $sql = "SELECT id, username, email, password
                FROM users
                WHERE username = :login OR email = :login
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $usernameOrEmail);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: resumes.php");
            exit;
        } else {
            $errorMessage = "Invalid username, email and/or password!!";
        }
    }
}
?>

<main class="container mt-4">
    <h2>Login</h2>

    <?php if ($errorMessage !== ""): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-3">
        <!-- user or email to login -->
        <label for="username_or_email" class="form-label">Username or Email</label>
        <input
            type="text"
            id="username_or_email"
            name="username_or_email"
            class="form-control mb-3"
            required
        >

        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-4"
            required
        >

        <!-- buttons -->
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-secondary">Register</a>
    </form>
</main>

<!-- footer require -->
<?php require "includes/footer.php"; ?>