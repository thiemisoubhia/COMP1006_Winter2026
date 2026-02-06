<?php
require "includes/header.php";
//  TODO: connect to the database 
require "includes/connect.php";  

//   TODO: Grab form data (no validation or sanitization for this lab)
 $firstname = $_POST['first_name'];
 $lastname = $_POST['last_name'];
 $email = $_POST['email'];

/*
  1. Write an INSERT statement with named placeholders
  2. Prepare the statement
  3. Execute the statement with an array of values
*/

/*Insert*/
$sql = "INSERT INTO subscribers(first_name, last_name, email)
VALUES (:first_name, :last_name, :email)";

/*prepare the statement*/
$stmt = $pdo->prepare($sql);

//array of values - prevent sql injection
$stmt->execute([
    ':first_name' => $firstname,
    ':last_name'  => $lastname,
    ':email'      => $email
]);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribed</title>
</head>

<body>

    <main class="container mt-4">
        <h2>Thank You for Subscribing</h2>

        <!-- TODO: Display a confirmation message -->
        <!-- Example: "Thanks, Name! You have been added to our mailing list." -->
        <?php echo "<h2>Thanks, " . $firstname . "! You have been added to our mailing list. </h2>" ?>

        <p class="mt-3">
            <a href="subscribers.php">View Subscribers</a>
        </p>
    </main>
</body>

</html>