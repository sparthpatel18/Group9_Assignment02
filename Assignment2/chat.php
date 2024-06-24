<?php 
  // Start a new or resume an existing session
  session_start();

  // Include the database configuration file
  include_once "php/config.php";

  // Redirect to login page if the user is not logged in
  if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          // Get the user ID from the URL parameter
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

          // Query to select user details based on the user ID
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");

          // Check if a user with the given ID exists
          if(mysqli_num_rows($sql) > 0){
            // Fetch user details
            $row = mysqli_fetch_assoc($sql);
          } else {
            // Redirect to users page if the user with the given ID does not exist
            header("location: users.php");
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <!-- Hidden input to store the incoming user ID -->
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <!-- Input field for typing a message -->
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <!-- Button to send a message -->
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <!-- Include the JavaScript file for chat functionality -->
  <script src="javascript/chat.js"></script>

</body>
</html>
