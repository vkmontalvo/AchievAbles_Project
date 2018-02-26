<?php

include './dbfunctions.php';
//================================================================
// Sign Up Form
//================================================================
// If the Sign Up form was submitted, gather user input
$user = filter_input(INPUT_POST, 'usrname1');
$email = filter_input(INPUT_POST, 'email1');
$pwd = filter_input(INPUT_POST, 'passwrd1');
$group = 'User';
$salt = 'B3li3v3';
$sha = sha1($salt . $pwd);
$success = addUser($email, $user, $sha, $group);
$usrerror = "";

// If the user is successfully added, log them in
if ($success === true) {
    $login = login($user, $sha);

    // If the user successgully logs in, redirect to the user dashboard page and start session
    if ($login === true) {
        $_SESSION['user'] = $user;

        header('Location:userdash.php');
        exit;
    }

    // If the user is not successfully logged in, show error
    else {
        $error = "Cannot login. Please try again later.";
    }
}

// if the user was not successfully added to the database, show error
else {
    $error = "Could not add user. Please try again later.";
}