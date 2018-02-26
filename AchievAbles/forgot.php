<?php
include './dbfunctions.php';

if(!empty($_POST["email"])) {
    $email = $_POST["email"];
    
    $exists = checkEmail($email);
    
    if (!$exists){
        echo 'Email does not match any records.';
    }
    
    else {
        echo '';
    }
}

