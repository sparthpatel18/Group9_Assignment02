<?php
    // Start a new or resume an existing session
    session_start();

    // Include the database configuration file
    include_once "config.php";

    // Get the unique ID of the logged-in user
    $outgoing_id = $_SESSION['unique_id'];

    // Get the search term from the POST parameters
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    // SQL query to search for users based on the search term
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";

    // Initialize the output variable
    $output = "";

    // Execute the SQL query
    $query = mysqli_query($conn, $sql);

    // Check if there are any users found based on the search term
    if(mysqli_num_rows($query) > 0){
        // Include data.php to display the user search results
        include_once "data.php";
    }else{
        // If no users found, update the output variable
        $output .= 'No user found related to your search term';
    }

    // Output the result
    echo $output;
?>
