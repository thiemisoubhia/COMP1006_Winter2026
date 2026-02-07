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
                class="btn btn-sm btn-warning">
                Edit
              </a>

              <form
                action="delete_resume.php"
                method="post"
                class="d-inline"
                onsubmit="return confirm('Are you sure you want to delete this resume?');">
                <input type="hidden" name="id" value="<?= $resume['id'] ?>">
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