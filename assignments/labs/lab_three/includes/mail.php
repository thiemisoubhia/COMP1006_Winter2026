<?php require "includes/header.php";

$firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

//server validation
$errors = [];

//require firstname
if ($firstname === null || $firstname === '') {
    $errors[] = "First name is required.";
}

//require lastname
if ($lastname === null || $lastname === '') {
    $errors[] = "Last name is required.";
}

//require message
if ($message === null || $message === '') {
    $errors[] = "Message is required.";
}

// email validation
if ($email === null || $email === '') {
    $errors[] = "Email is required.";
} 
// email format validation
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email must be a valid email";
}


?>

<main>

    <?php echo "<h2>Message sent! Thank for your message " . $firstname . "!</h2>" ?>
    <h3>Our team are going to reach you out in 2 bussines days</h3>
</main>

<!-- send email using mail function -->
 <!-- mail($to, $subject, $message); -->

<?php require "includes/footer.php"; ?>