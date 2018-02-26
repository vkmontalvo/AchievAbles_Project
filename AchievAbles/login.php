<?php

include './dbfunctions.php';
//================================================================
// Login Form
//================================================================
// If the Sign Up form was submitted, gather user input

$user = filter_input(INPUT_POST, 'usrname2');
$pwd = filter_input(INPUT_POST, 'passwrd2');
$salt = 'B3li3v3';
$sha = sha1($salt . $pwd);

$login = login($user, $sha);

// If successfully logged in, start session
if ($login === true) {
    $_SESSION['user'] = $user;
    $admin = groupValidate($user);

    // If admin user, send to admin dashboard. Else, send to user dashboard
    if ($admin === true) {
        header('Location:admindash.php');
        exit;
    } else {
        header('Location:userdash.php');
        exit;
    }
}

// If unsuccessful login, show error
else {
    $loginerror = "Incorrect username or password.";
}
