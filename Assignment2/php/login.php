<?php 
    // Start a new or resume an existing session
    session_start();

    // Include the database configuration file
    include_once "config.php";

    // Get the email and password from the POST data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if both email and password are provided
    if(!empty($email) && !empty($password)){

        // Query the database to find a user with the given email
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

        // Check if a user with the provided email exists
        if(mysqli_num_rows($sql) > 0){
            // Fetch user data
            $row = mysqli_fetch_assoc($sql);

            // Hash the provided password for comparison
            $user_pass = md5($password);
            $enc_pass = $row['password'];

            // Check if the hashed passwords match
            if($user_pass === $enc_pass){
                // Update user status to "Active now"
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");

                // Check if the status update was successful
                if($sql2){
                    // Set the 'unique_id' session variable and indicate success
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    // Indicate an error if the status update fails
                    echo "Something went wrong. Please try again!";
                }
            }else{
                // Indicate incorrect email or password
                echo "Email or Password is Incorrect!";
            }
        }else{
            // Indicate that the provided email does not exist
            echo "$email - This email does not exist!";
        }
    }else{
        // Indicate that both email and password are required
        echo "All input fields are required!";
    }
?>
