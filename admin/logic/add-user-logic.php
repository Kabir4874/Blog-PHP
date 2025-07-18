<?php

require '../config/database.php';

// get  form data if submit button was clicked 
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    // validate input values 
    if (!$firstname) {
        $_SESSION['add-user'] = 'Please enter your first name';
    } elseif (!$lastname) {
        $_SESSION['add-user'] = 'Please enter your last name';
    } elseif (!$username) {
        $_SESSION['add-user'] = 'Please enter your username';
    } elseif (!$email) {
        $_SESSION['add-user'] = 'Please enter your valid email';
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = 'Password should be 8+ character';
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = 'Please add avatar';
    } else {
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = 'Password do not match';
        } else {
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exist in database 
            $user_check_query = 'SELECT * FROM users WHERE username="$username" OR email="$email"';

            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = 'Username or Email already exist';
            } else {
                // work on avatar 
                $time = time();

                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../../assets/' . $avatar_name;

                // make sure file is an image 
                $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);

                if (in_array($extension, $allowed_files)) {
                    // make sure image is not too large (1mb+)
                    if ($avatar['size'] < 1000000) {
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = 'File size too big. Should be less than 1mb';
                    }
                } else {
                    $_SESSION['add-user'] = 'File should be png, jpg, jpeg or webp';
                }
            }
        }
    }

    // redirect back to add-user page if there was any error 
    if (isset($_SESSION['add-user'])) {
        //  pass form data back to add-user page 
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        // insert new user into users table 
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name','$is_admin')";

        $insert_user_result =  mysqli_query($connection, $insert_user_query);

        if (!mysqli_errno($connection)) {
            $_SESSION['add-user-success'] = 'User added successfully.';
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
        }
    }
} else {
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}
