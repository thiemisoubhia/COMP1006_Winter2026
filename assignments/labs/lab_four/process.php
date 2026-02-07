<?php
//  TODO: connect to the database 
require_once "includes/connect.php";

//   TODO: Grab form data (no validation or sanitization for this lab)
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
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


//map the named placeholder to the user data
$stmt->bindParam(':first_name', $firstName);
$stmt->bindParam(':last_name', $lastName);
$stmt->bindParam(':email', var: $email);


//execute statement
$stmt->execute();

//close the connection after that
$pdo = null;

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
        <?php echo "<h2>Thanks, " . $firstName . "! You have been added to our mailing list. </h2>" ?>

        <p class="mt-3">
            <a href="subscribers.php">View Subscribers</a>
        </p>
    </main>
</body>

</html>