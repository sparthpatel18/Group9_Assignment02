<?php
    // Loop through each row of the result set obtained from the query
    while($row = mysqli_fetch_assoc($query)){

        // Query to retrieve the latest message for the current user
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";

        // Execute the query to retrieve the latest message
        $query2 = mysqli_query($conn, $sql2);

        // Fetch the result row from the executed query
        $row2 = mysqli_fetch_assoc($query2);

        // Set $result to the latest message if available, otherwise set it to a default message
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";

        // Trim the message text if it's longer than 28 characters
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

        // Determine if the message is from the current user (You)
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }

        // Determine the online status of the user
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

        // Determine if the current user is the same as the outgoing user (hide current user)
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        // Concatenate the HTML output for each user with their details
        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>
