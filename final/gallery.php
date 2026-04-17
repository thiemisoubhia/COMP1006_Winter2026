<?php
require_once "connect.php";

require "includes/auth.php"; // check user login

//special header
include "includes/header_login.php";

// Select resumes

$sqlSelect = "SELECT id, picture, legend
FROM gallery WHERE user_id = :user_id ORDER BY id DESC";

$stmt = $pdo->prepare($sqlSelect);
$stmt->execute([':user_id' => $_SESSION['user_id']]);

$resumes = $stmt->fetchAll(PDO::FETCH_ASSOC);


//delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $id = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);

  $sql = "DELETE FROM gallery 
        WHERE id = :id AND user_id = :user_id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id' => $id,
    ':user_id' => $_SESSION['user_id']
  ]);

  header("Location: gallery.php");
  exit;
}

?>

<main class="container mt-4">
  <h1>Gallery</h1>

  <?php if (count($resumes) === 0): ?>
    <p>No images found.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Legend</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($images as $image): ?>
          <tr>
            <td><?= htmlspecialchars($image['id']) ?></td>
            <td>
              <img src="<?= htmlspecialchars($image['picture']) ?>"
                alt="Picture"
                width="50" height="50">
            </td>
            <td><?= htmlspecialchars($image['legend']) ?></td>
            <td class="text-nowrap">
              <form method="post" class="d-inline"
                onsubmit="return confirm('Are you sure you want to delete this image?');">
                <input type="hidden" name="delete_id" value="<?= $image['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a class="btn btn-danger" href="logout.php">Logout</a>
    <a class="btn btn-dark" href="form.php">Create a Resume</a>
  </p>
</main>

<?php require "parts/footer.php"; ?>