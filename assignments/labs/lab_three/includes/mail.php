<?php require "includes/header.php";

$firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

?>

<main>

    <?php echo "<h2>Message sent! Thank for your message " . $firstname . "!</h2>" ?>
    <h3>Our team are going to reach you out in 2 bussines days</h3>
</main>

<!-- send email using mail function -->
 <!-- mail($to, $subject, $message); -->

<?php require "includes/footer.php"; ?>