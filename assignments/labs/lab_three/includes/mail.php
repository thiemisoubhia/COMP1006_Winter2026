<?php require "includes/header.php";

//getting the data from the form
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

//checking the errors
if (!empty($errors)) {
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
} 
//show message when sent
else{
?>
<main>

    <?php echo "<h2>Message sent! Thank for your message " . $firstname . "!</h2>" ?>
    <h3>Our team will reach out within 2 business days</h3>
</main>
<?php }?>
<!-- send email using mail function -->
<!-- mail($to, $subject, $message); -->

<?php require "includes/footer.php"; ?>