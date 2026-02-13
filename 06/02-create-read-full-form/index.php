<?php require "includes/header.php" ?>
<main>
  <h2> Order Online - Easy & Simple (And Totally Secure...) 🧁</h2>
  <form action="process.php" method="post">

    <!-- Customer Information -->
    <!-- Step One - Add Client Side Validation with HTML Attributes -->
    <fieldset>
      <legend>Customer Information</legend>
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name">
        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name">
        <label for="phone">Phone number</label>
        <input type="tel" id="phone" name="phone" placeholder="555-123-4567">
        <label for="address">Address</label>
        <input type="text" id="address" name="address">
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
    </fieldset>

    <!-- Order Details -->
    <fieldset>
      <legend>Order Details</legend>

      <p>
        Enter a quantity for each item (use 0 if you don't want it).
      </p>

      <table border="1" cellpadding="8" cellspacing="0">
        <thead>
          <tr>
            <th scope="col">Baked Treat</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Chaos Croissant 🥐</th>
            <td>
              <label for="chaos_croissant" class="visually-hidden">Chaos Croissant quantity</label>
              <input type="number" id="chaos_croissant" name="items[chaos_croissant]" min="0" max="24" value="0">
            </td>
          </tr>

          <tr>
            <th scope="row">Existential Éclair 🤔</th>
            <td>
              <label for="existential_eclair" class="visually-hidden">Existential Éclair quantity</label>
              <input type="number" id="existential_eclair" name="items[existential_eclair]" min="0" max="24"
                value="0">
            </td>
          </tr>

          <tr>
            <th scope="row">Procrastination Cookie ⏰</th>
            <td>
              <label for="procrastination_cookie" class="visually-hidden">Procrastination Cookie quantity</label>
              <input type="number" id="procrastination_cookie" name="items[procrastination_cookie]" min="0" max="24"
                value="0">
            </td>
          </tr>

    
        </tbody>
      </table>

    </fieldset>

    <fieldset>
      <legend>Additional Comments</legend>

      <p>
        <label for="comments">Comments (optional)</label><br>
        <textarea id="comments" name="comments" rows="4"
          placeholder="Allergies, delivery instructions, custom messages..."></textarea>
      </p>
    </fieldset>

    <p>
      <button type="submit">Place Order</button>
    </p>

  </form>
</main>
</body>

</html>

<?php require "includes/footer.php" ?>