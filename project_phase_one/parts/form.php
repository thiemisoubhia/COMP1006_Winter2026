  <div id="forms">
       <h2>Creating your <img src="images/logo.png" alt="" width="150px"></h2>
       <form method="POST" action="create.php">
           <div class="row mb-3">
               <div class="col">
                   <label for="firstName" class="form-label">First Name</label>
                   <input type="text" class="form-control" id="firstName" name="firstName" required>
               </div>
               <div class="col">
                   <label for="lastName" class="form-label">Last Name</label>
                   <input type="text" class="form-control" id="lastName" name="lastName" required>
               </div>
           </div>

           <div class="mb-3">
               <label for="position" class="form-label">Current Position</label>
               <input type="text" class="form-control" id="position" name="position" required>
           </div>

           <div class="mb-3">
               <label for="skills" class="form-label">Skills (comma-separated)</label>
               <input type="text" class="form-control" id="skills" name="skills" placeholder="e.g., Java, HTML, CSS">
           </div>

           <div class="row mb-3">
               <div class="col">
                   <label for="email" class="form-label">Email</label>
                   <input type="email" class="form-control" id="email" name="email" required>
               </div>
               <div class="col">
                   <label for="phone" class="form-label">Phone Number</label>
                   <input type="tel" class="form-control" id="phone" name="phone">
               </div>
           </div>

           <div class="mb-3">
               <label for="bio" class="form-label">Short Bio</label>
               <textarea class="form-control" id="bio" rows="3" name="bio"></textarea>
           </div>

           <button type="submit" class="btn btn-primary">Submit</button>
       </form>

   </div>

   <!-- end container div -->
   </div>