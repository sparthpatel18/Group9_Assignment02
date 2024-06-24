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

        // Initialize an empty variable to store the chat output
        $output = "";

        // SQL query to retrieve messages and user details for the chat
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";

        // Execute the SQL query
        $query = mysqli_query($conn, $sql);

        // Check if there are messages available
        if(mysqli_num_rows($query) > 0){
            // Loop through each row of the result set
            while($row = mysqli_fetch_assoc($query)){
                // Check if the message is outgoing (from the current user)
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }else{
                    // Message is incoming (from the other user)
                    $output .= '<div class="chat incoming">
                                <img src="php/images/'.$row['img'].'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            // No messages available
            $output .= '<div class="text">No messages are available. Once you send a message, it will appear here.</div>';
        }

        // Output the generated chat content
        echo $output;
    }else{
        // Redirect to the login page if the user is not logged in
        header("location: ../login.php");
    }
?>
