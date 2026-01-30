<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>>Bake It Till You Make It</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
    <h2>Contact Bake It Till You Make It</h2>
    <!-- bootstap form -->
    <form action="contact.php" method="POST">
        <div class="mb-3">
            <label for="firstName" class="form-label">First name:</label>
            <input type="text" class="form-control" id="firstName" name="firstname" required>
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">Last name:</label>
            <input type="text" class="form-control" id="lastName" name="lastname" required>
        </div>

        <div class="mb-3">
            <label for="emailAddr" class="form-label">Email address:</label>
            <input type="email" class="form-control" id="emailAddr" name="email" aria-describedby="emailHelp" required>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Leave a comment here" id="message" name="message" style="height: 100px" required></textarea>
            <label for="message">Message</label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>