<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    
} else {

    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
