<?php
require "includes/auth.php";

require "connect.php";
//special header
include "includes/header_login.php";

?>

<main class="container mt-4">
    <h2>Add a new Image to The Gallery</h2>
    <h4>Welcome <?= htmlspecialchars($_SESSION['user_name']) ?>!</h4>

    <form method="post" action="create.php" enctype="multipart/form-data">

        <label>Title</label>
        <textarea name="title" class="form-control mb-3" required></textarea>

        <label>Image</label>
        <input type="file" name="picture" class="form-control mb-3" accept=".jpg,.jpeg,.png,.webp" required>


        <button class="btn btn-success">Submit</button>
    </form>

</main>

<?php require "includes/footer.php"; ?>