<?php

// Start the session
session_start();

include './dbfunctions.php';
//================================================================
// Login Form
//================================================================
// If the Sign Up form was submitted, gather user input

$user = filter_input(INPUT_POST, "user2");
$pwd = filter_input(INPUT_POST, "passwrd2");
$salt = 'B3li3v3';
$sha = sha1($salt . $pwd);

$login = loginValidate($user, $sha);

// If correct credentials entered, delete account
if ($login === true) {
    $success = deleteAccount($user);

    // If admin user, send to admin dashboard. Else, send to user dashboard
    if ($success === true) {
        // Destroy the session 
        session_destroy();
        header('Location:index.php');
        exit;
    }
    
    else {
        $message = "Something went wrong. Please try again.";
        echo "<script type='text/javascript'>alert('$message');window.location.replace('accountedit.php');</script>";
        exit;
    }
}

else {
        $message = "Invalid Username or Password. Please try again.";
        echo "<script type='text/javascript'>alert('$message');window.location.replace('accountedit.php');</script>";
        exit;
    }

