<?php 
  // Start a session to track user login state
  session_start();
  // If the user is already logged in, redirect them to the users.php page
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <!-- Signup form section -->
    <section class="form signup">
      <header>Realtime Chat App</header>
      <!-- Signup form with input fields for user details -->
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Display error messages here -->
        <div class="error-text"></div>
        <!-- User's first and last name input fields -->
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name" required>
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
        </div>
        <!-- User's email input field -->
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <!-- User's password input field with an option to show/hide the password -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <i class="fas fa-eye"></i> <!-- Show/Hide password icon -->
        </div>
        <!-- User's profile image upload field -->
        <div class="field image">
          <label>Select Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <!-- Continue to Chat button -->
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <!-- Link to the login page for users who already have an account -->
      <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
  </div>

  <!-- JavaScript files for password show/hide functionality and signup form handling -->
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>

</body>
</html>
