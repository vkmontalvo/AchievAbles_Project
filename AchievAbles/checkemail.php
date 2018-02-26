<?php
include './dbfunctions.php';

if(!empty($_POST["email"])) {
    $email = $_POST["email"];
    
    $exists = checkEmail($email);
    
    if (!$exists){
        echo '';
    }
    
    else {
        echo 'There is already an account under this email.';
    }
}

