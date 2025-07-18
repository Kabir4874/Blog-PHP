<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../config/database.php';

// Get signup form data if signup button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Validate input values
    $errors = [];
    if (!$firstname) {
        $errors[] = 'Please enter your first name';
    }
    if (!$lastname) {
        $errors[] = 'Please enter your last name';
    }
    if (!$username) {
        $errors[] = 'Please enter your username';
    }
    if (!$email) {
        $errors[] = 'Please enter a valid email';
    }
    if (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $errors[] = 'Password should be 8+ characters';
    }
    if (!$avatar['name']) {
        $errors[] = 'Please add an avatar';
    } elseif ($createpassword !== $confirmpassword) {
        $errors[] = 'Passwords do not match';
    }

    if (!empty($errors)) {
        $_SESSION['signup'] = implode('<br>', $errors);
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

    // Hash the password
    $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

    // Check if username or email already exist in database
    $user_check_query = 'SELECT * FROM users WHERE username=? OR email=?';
    $stmt = mysqli_prepare($connection, $user_check_query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $user_check_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($user_check_result) > 0) {
        $_SESSION['signup'] = 'Username or Email already exists';
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

    // Work on avatar upload
    $upload_dir = __DIR__ . '/../assets/'; // Absolute path to assets directory

    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Validate the file
    $allowed_extensions = ['png', 'jpg', 'jpeg', 'webp'];
    $max_file_size = 1000000; // 1MB in bytes
    $extension = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));

    // Check if file was actually uploaded
    if (!is_uploaded_file($avatar['tmp_name'])) {
        $_SESSION['signup'] = 'Invalid file upload attempt';
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

    // Check directory permissions
    if (!is_writable($upload_dir)) {
        $_SESSION['signup'] = 'Upload directory is not writable';
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

    // Validate file type
    if (!in_array($extension, $allowed_extensions)) {
        $_SESSION['signup'] = 'File should be png, jpg, jpeg or webp';
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

    // Validate file size
    if ($avatar['size'] > $max_file_size) {
        $_SESSION['signup'] = 'File size too big. Should be less than 1MB';
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

    // Generate a unique filename
    $time = time();
    $safe_filename = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $avatar['name']);
    $avatar_name = $time . '_' . $safe_filename;
    $final_destination = $upload_dir . $avatar_name;

    // Move the file
    if (!move_uploaded_file($avatar['tmp_name'], $final_destination)) {
        $_SESSION['signup'] = 'Failed to upload file';
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

    // Insert new user into users table using prepared statement
    $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES (?, ?, ?, ?, ?, ?, 0)";
    $stmt = mysqli_prepare($connection, $insert_user_query);
    mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $username, $email, $hashed_password, $avatar_name);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['signup-success'] = 'Registration successful. Please login';
        header('location: ' . ROOT_URL . 'signin.php');
    } else {
        // Delete the uploaded file if database insertion fails
        if (file_exists($final_destination)) {
            unlink($final_destination);
        }
        $_SESSION['signup'] = 'Database error: ' . mysqli_error($connection);
        header('location: ' . ROOT_URL . 'signup.php');
    }
} else {
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
