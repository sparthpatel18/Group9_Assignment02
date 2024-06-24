<?php
  // Database connection parameters
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chatapp";

  // Establishing a connection to the database using MySQLi
  $conn = mysqli_connect($hostname, $username, $password, $dbname);

  // Checking if the connection is successful
  if (!$conn) {
    // Outputting an error message if the connection fails
    echo "Database connection error: " . mysqli_connect_error();
  }
?>
