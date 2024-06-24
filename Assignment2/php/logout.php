<?php
    // Start a new or resume an existing session
    session_start();

    // Check if the 'unique_id' session variable is set, indicating an authenticated user
    if(isset($_SESSION['unique_id'])){
        // Include the database configuration file
        include_once "config.php";

        // Get the 'logout_id' from the GET parameters
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);

        // Check if 'logout_id' is set, indicating a specific user's logout
        if(isset($logout_id)){
            // Set the user's status to "Offline now"
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");

            // Check if the status update was successful
            if($sql){
                // Unset all session variables and destroy the session
                session_unset();
                session_destroy();

                // Redirect to the login page
                header("location: ../login.php");
            }
        }else{
            // Redirect to the users page if 'logout_id' is not set
            header("location: ../users.php");
        }
    }else{
        // Redirect to the login page if the user is not authenticated
        header("location: ../login.php");
    }
?>
