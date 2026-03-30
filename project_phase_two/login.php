<?php
//start a session to manage user login
session_start();

//database connection
require "connect.php";
require "parts/header.php";

//error message
$errorMessage = "";

//process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errorMessage = "Email and password are required.";
    } else {
        //select user by email
        $sql = "SELECT id, first_name, last_name, email, password
                FROM users
                WHERE email = :email
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //verify password
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];

            //redirect to resumes page after login
            header("Location: resumes.php");
            exit;
        } else {
            $errorMessage = "Invalid email and/or password.";
        }
    }
}
?>

<main class="flex-grow-1 d-flex align-items-center p-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2>Login</h2>

                <!-- display errors -->
                <?php if ($errorMessage !== ""): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($errorMessage); ?>
                    </div>
                <?php endif; ?>

                
                <form method="post" class="mt-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
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

                    <button type="submit" class="btn btn-dark w-100">Login</button>
                    <a href="register.php" class="btn btn-secondary w-100 mt-2">Register</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require "parts/footer.php"; ?>