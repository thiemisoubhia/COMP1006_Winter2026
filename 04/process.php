<?php require "includes/header.php";

// access the form data and then echo on the page in a confirmation message
// $firstname = $_POST['first_name'];
// $lastname = $_POST['last_name'];
// $address = $_POST['address'];
// $email = $_POST['email'];
// $items = $_POST['items'];

$firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$items = $_POST['items'] ?? [];

//validation time = serverside

$errors = [];

//require text fields
if ($firstname === null || $firstname === '') {
    $errors[] = "First Name is Required.";
}

if ($lastname === null || $lastname === '') {
    $errors[] = "Last Name is Required.";
}

// email validation
if ($email === null || $email === '') {
    $errors[] = "Email is Required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email must be a valid email";
}

if ($address === null || $address === '') {
    $errors[] = "Address is Required.";
}

$itemsOrdered = [];

// check that the order quantity is a number
foreach ($items as $items => $quantity) {
    if (filter_var($quantity, FILTER_VALIDATE_INT) != false && $quantity > 0) {
        $itemsOrdered[$items] = $quantity;
    }
}

if (count($itemsOrdered) === 0) {
    $errors[] = "Please order at least one item";
}

if (!empty($errors)) {
    foreach ($errors as $error) : ?>
        <li><?php echo $error; ?></li>
<?php endforeach;
}


//stop the script 
exit;

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