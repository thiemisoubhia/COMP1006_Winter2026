<?php 
//require header
require_once 'parts/header.php'; 
?>

<body>
    <main class="container text-center mt-5">
        <!--message for users who are not logged in -->
        <h1>Sorry, you must be logged in to create your ResuME!</h1>
        
        <!-- button to login -->
        <a href="login.php" class="btn btn-dark mt-3">Login</a>
    </main>
</body>

</html>

<?php 
// Include the site footer
require_once 'parts/footer.php'; 
?>