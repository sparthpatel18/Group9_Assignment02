<?php
    // Start a new or resume an existing session
    session_start();

    // Include the database configuration file
    include_once "config.php";

    // Get user input data from the POST parameters
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if all required fields are not empty
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        // Check if the email is in a valid format
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // Check if the email already exists in the database
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                // If email already exists, display an error message
                echo "$email - This email already exists!";
            }else{
                // If email is unique, proceed with image upload and registration
                if(isset($_FILES['image'])){
                    // Extract information about the uploaded image
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];

                    // Extract image extension
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);

                    // Allowed image extensions
                    $extensions = ["jpeg", "png", "jpg"];

                    // Check if the uploaded image has a valid extension
                    if(in_array($img_ext, $extensions) === true){
                        // Check if the uploaded image has a valid type
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            // Generate a unique ID and set user status to "Active now"
                            $ran_id = rand(time(), 100000000);
                            $status = "Active now";

                            // Encrypt the password using MD5
                            $encrypt_pass = md5($password);

                            // Move the uploaded image to the 'images' directory
                            $new_img_name = time().$img_name;
                            if(move_uploaded_file($tmp_name, "images/".$new_img_name)){
                                // Insert user data into the database
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");

                                // Check if the insertion was successful
                                if($insert_query){
                                    // Retrieve user data from the database
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

                                    // Check if the user data was retrieved successfully
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);

                                        // Set the unique ID in the session variable
                                        $_SESSION['unique_id'] = $result['unique_id'];

                                        // Display success message
                                        echo "success";
                                    }else{
                                        // Display an error message if the email address does not exist
                                        echo "This email address does not exist!";
                                    }
                                }else{
                                    // Display an error message if something went wrong during insertion
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            // Display an error message for invalid image types
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        // Display an error message for invalid image extensions
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            // Display an error message for an invalid email format
            echo "$email is not a valid email!";
        }
    }else{
        // Display an error message for empty input fields
        echo "All input fields are required!";
    }
?>
