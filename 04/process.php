<?php require "includes/header.php";

// access the form data and then echo on the page in a confirmation message
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$address = $_POST['address'];
$email = $_POST['email'];
$items = $_POST['items'];

?>

<main>

    <?php echo "<h2>Thank for your order " . $firstname . "</h2>" ?>

    <h3>Items Ordered </h3>
    <ul>
        <?php foreach ($items as $items => $quantity): ?>
            <li><?php $items ?> - <?php $quantity ?></li>
        <?php endforeach; ?>
    </ul>
</main>

<!-- send email using mail function -->
 <!-- mail($to, $subject, $message); -->

<?php require "includes/footer.php"; ?>