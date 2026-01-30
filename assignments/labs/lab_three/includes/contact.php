<form action="connect.php" method="post">

    <!-- Contact Information -->
    <fieldset>
        <legend>Contact Information</legend>

        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="firstname" required>

        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="lastname" required>

        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required>

    </fieldset>

    <!-- Message -->
    <fieldset>
        <legend>Message</legend>

        <p>
            <label for="message">Your Message</label><br>
            <textarea 
                id="message" 
                name="message" 
                rows="4" 
                placeholder="Type your message here..." 
                required></textarea>
        </p>

    </fieldset>

    <p>
        <button type="submit">Submit</button>
    </p>

</form>
