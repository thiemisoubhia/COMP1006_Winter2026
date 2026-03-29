<?php
require_once "connect.php";
include "parts/header.php";

// Select resumes
$sqlSelect = "
  SELECT id, first_name, last_name, position, skills, email, phone, bio
  FROM resumes
  ORDER BY id DESC
";

$stmt = $pdo->prepare($sqlSelect);
$stmt->execute();

$resumes = $stmt->fetchAll(PDO::FETCH_ASSOC);


//delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $id = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);

  if ($id) {
    $sql = "DELETE FROM resumes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
  }

  header("Location: resumes.php");
  exit;
}

?>

<main class="container mt-4">
  <h1>Resumes</h1>

  <?php if (count($resumes) === 0): ?>
    <p>No resumes found.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Position</th>
          <th>Skills</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Bio</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resumes as $resume): ?>
          <tr>
            <td><?= $resume['id'] ?></td>
            <td><?= $resume['first_name'] ?></td>
            <td><?= $resume['last_name'] ?></td>
            <td><?= $resume['position'] ?></td>
            <td><?= $resume['skills'] ?></td>
            <td><?= $resume['email'] ?></td>
            <td><?= $resume['phone'] ?></td>
            <td><?= $resume['bio'] ?></td>
            <td class="text-nowrap">
              <a
                href="edit_resume.php?id=<?= $resume['id'] ?>"
                class="btn btn-sm btn-secondary">
                Edit
              </a>

              <form
                method="post"
                class="d-inline"
                onsubmit="return confirm('Are you sure you want to delete this resume?');">
                <input type="hidden" name="delete_id" value="<?= $resume['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">
                  Delete
                </button>
              </form>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>


  <p class="mt-3">
    <a class="btn btn-dark" href="index.php">Back</a>
  </p>
</main>

<?php require "parts/footer.php"; ?>