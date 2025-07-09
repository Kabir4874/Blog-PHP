<?php

require 'config/database.php';

// get signup form data if signup button was clicked 
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // validate input values 
    if (!$firstname) {
        $_SESSION['signup'] = 'Please enter your first name';
    } elseif (!$lastname) {
        $_SESSION['signup'] = 'Please enter your last name';
    } elseif (!$username) {
        $_SESSION['signup'] = 'Please enter your username';
    } elseif (!$email) {
        $_SESSION['signup'] = 'Please enter your valid email';
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = 'Password should be 8+ character';
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = 'Please add avatar';
    } else {
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = 'Password do not match';
        } else {
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exist in database 
            $user_check_query = 'SELECT * FROM users WHERE username="$username" OR email="$email"';

            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = 'Username or Email already exist';
            } else {
                // work on avatar 
                $time = time();

                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'assets/' . $avatar_name;

                // make sure file is an image 
                $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);

                if (in_array($extension, $allowed_files)) {
                    // make sure image is not too large (1mb+)
                    if ($avatar['size'] < 1000000) {
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = 'File size too big. Should be less than 1mb';
                    }
                } else {
                    $_SESSION['signup'] = 'File should be png, jpg, jpeg or webp';
                }
            }
        }
    }

    // redirect back to signup page if there was any error 
    if (isset($_SESSION['signup'])) {
        //  pass form data back to signup page 
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert new user into users table 
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name',0)";

        $insert_user_result =  mysqli_query($connection, $insert_user_query);

        if (!mysqli_errno($connection)) {
            $_SESSION['signup-success'] = 'Registration successful. Please login';
            header('location: ' . ROOT_URL . 'signin.php');
        }
    }
} else {
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
