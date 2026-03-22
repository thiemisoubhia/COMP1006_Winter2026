<?php
// database connection
require "includes/connect.php";

// header
require "includes/header.php";

// sql query to get all users
$sql = "SELECT username, email, image FROM users ORDER BY id DESC";

// prepare and execute query
$stmt = $pdo->prepare($sql);
$stmt->execute();

// fetch users
$users = $stmt->fetchAll();
?>

<main class="container mt-4">
    <h2 class="mb-4">User Profiles</h2>

    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">

                    <!-- image -->
                    <?php if (!empty($user['image'])): ?>
                        <img src="<?= htmlspecialchars($user['image']); ?>" 
                             class="card-img-top" 
                             style="height:200px; object-fit:cover;">
                    <?php else: ?>
                        <!-- show NO IMAGE if not found-->
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <!-- username -->
                        <h5 class="card-title">
                            <?= htmlspecialchars($user['username']); ?>
                        </h5>

                        <!-- email -->
                        <p class="card-text text-muted">
                            <?= htmlspecialchars($user['email']); ?>
                        </p>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php
// footer
require "includes/footer.php";
?>