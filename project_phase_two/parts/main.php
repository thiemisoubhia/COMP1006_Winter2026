<main>

    <div id="main" class="py-5">
        <div class="container text-center">

            <!-- Project title and description -->
            <h1 class="mb-4">Welcome to ResuMe</h1>
            <p class="lead mb-4">
                Build your professional resume quickly and easily.
                Follow our tips and log in to start filling in your details to create a polished resume ready for your next opportunity!
            </p>

            <!-- Options -->
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!--user not logged in show login and register-->
                <a href="login.php" class="btn btn-dark btn-lg mx-2">Login</a>
                <a href="register.php" class="btn btn-secondary btn-lg mx-2">Register</a>
            <?php else: ?>
                <!--user logged in show to start creating a resume -->
                <a href="create_resume.php" class="btn btn-dark btn-lg mx-2">Create Your Resume</a>
            <?php endif; ?>


        </div>
    </div>
</main>