<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // Get form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // Validate form data
    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Enter post title";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post. Select post category";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Enter post body";
    } else {
        // Handle new thumbnail upload if provided
        if ($thumbnail['name']) {
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../../assets/' . $thumbnail_name;

            // Check if file is an image
            $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
            $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));

            if (in_array($extension, $allowed_files)) {
                // Check file size
                if ($thumbnail['size'] < 2_000_000) {
                    // Upload new thumbnail
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

                    // Delete old thumbnail if it exists
                    $old_thumbnail = $_POST['old_thumbnail'] ?? null;
                    if ($old_thumbnail) {
                        $old_thumbnail_path = '../../assets/' . $old_thumbnail;
                        if (file_exists($old_thumbnail_path)) {
                            unlink($old_thumbnail_path);
                        }
                    }
                } else {
                    $_SESSION['edit-post'] = "Couldn't update post. File size too big. Should be less than 2mb";
                }
            } else {
                $_SESSION['edit-post'] = "Couldn't update post. File should be png, jpg, jpeg or webp";
            }
        }
    }

    // Redirect back if there are errors
    if (isset($_SESSION['edit-post'])) {
        $_SESSION['edit-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        die();
    } else {
        // Update is_featured for all posts if this post is featured
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Set thumbnail name - either new one or keep old one
        $thumbnail_to_insert = $thumbnail['name'] ? $thumbnail_name : $_POST['old_thumbnail'];

        // Update post in database
        $query = "UPDATE posts SET 
                  title='$title', 
                  body='$body', 
                  thumbnail='$thumbnail_to_insert', 
                  category_id=$category_id, 
                  is_featured=$is_featured 
                  WHERE id=$id LIMIT 1";

        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['edit-post'] = "Couldn't update post. Database error: " . mysqli_error($connection);
            header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
            die();
        } else {
            $_SESSION['edit-post-success'] = "Post updated successfully";
            header('location: ' . ROOT_URL . 'admin/index.php');
            die();
        }
    }
}

// If form wasn't submitted properly
header('location: ' . ROOT_URL . 'admin/index.php');
die();
