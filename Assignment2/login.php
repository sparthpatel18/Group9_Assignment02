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
    <!-- Login form section -->
    <section class="form login">
      <header>Realtime Chat App</header>
      <!-- Login form with input fields for user email and password -->
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Display error messages here -->
        <div class="error-text"></div>
        <!-- User's email input field -->
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <!-- User's password input field with an option to show/hide the password -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i> <!-- Show/Hide password icon -->
        </div>
        <!-- Continue to Chat button -->
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <!-- Link to the signup page for users who do not have an account -->
      <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
  </div>
  
  <!-- JavaScript files for password show/hide functionality and login form handling -->
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>

</body>
</html>
