<?php 
    // Start a new or resume an existing session
    session_start();

    // Check if the user is logged in (session has 'unique_id' set)
    if(isset($_SESSION['unique_id'])){
        // Include the database configuration file
        include_once "config.php";

        // Get the unique IDs of the outgoing and incoming users
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

        // Get the message content from the POST data
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // Check if the message content is not empty
        if(!empty($message)){
            // Insert the message into the 'messages' table
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
    }else{
        // Redirect to the login page if the user is not logged in
        header("location: ../login.php");
    }
?>
