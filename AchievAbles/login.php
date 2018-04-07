<?php

// Start the session
session_start();

include './dbfunctions.php';
//================================================================
// Login Form
//================================================================
// If the Sign Up form was submitted, gather user input

    $user = filter_input(INPUT_POST, "usrname2");
    $pwd = filter_input(INPUT_POST, "passwrd2");
    $salt = 'B3li3v3';
    $sha = sha1($salt . $pwd);

    $login = login($user, $sha);

// If successfully logged in, start session
    if ($login === true) {
        $_SESSION['user'] = $user;
        $_SESSION['login'] = true;
        $admin = groupValidate($user);

        // If admin user, send to admin dashboard. Else, send to user dashboard
        if ($admin === true) {
            $_SESSION['group'] = 'admin';
            header("location:admindash.php");
            exit;
        } else {
            $_SESSION['group'] = 'user';
            header("location:userdash.php");
            exit;
        }
    }
    
    else {
        $message = "Invalid Username or Password. Please try again.";
        echo "<script type='text/javascript'>alert('$message');window.location.replace('index.php');</script>";
    }

