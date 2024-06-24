<?php
    // Start a new or resume an existing session
    session_start();

    // Include the database configuration file
    include_once "config.php";

    // Get the unique ID of the current user from the session
    $outgoing_id = $_SESSION['unique_id'];

    // SQL query to select all users except the current user, ordered by user_id in descending order
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";

    // Execute the SQL query
    $query = mysqli_query($conn, $sql);

    // Initialize the output variable
    $output = "";

    // Check if there are no users available
    if(mysqli_num_rows($query) == 0){
        // If no users are available, update the output variable
        $output .= "No users are available to chat";
    } elseif(mysqli_num_rows($query) > 0) {
        // If there are users available, include data.php to display user information
        include_once "data.php";
    }

    // Output the result
    echo $output;
?>
