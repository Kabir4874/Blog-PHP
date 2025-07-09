<?php

require 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog Application | Admin - PHP</title>
    <!-- ?custom css  -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>styles/style.css" />
    <!-- ?unicons cdn -->
    <link
        rel="stylesheet"
        href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
</head>

<body>
    <!-- !navbar -->
    <nav>
        <div class="container nav_container">
            <a href="<?= ROOT_URL ?>index.php" class="nav_logo">KABIR</a>
            <ul class="nav_items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
                <li class="nav_profile">
                    <div class="avatar">
                        <img src="./assets/avatar1.jpg" alt="avatar" />
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>admin/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <button id="open_nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close_nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>