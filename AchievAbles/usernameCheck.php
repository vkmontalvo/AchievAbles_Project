<?php
include './dbfunctions.php';

if(!empty($_POST["username"])) {
    $user = $_POST["username"];
    
    $exists = checkUsername($user);
    
    if ($exists){
        echo 'Username exists!';
    }
    
    else {
        echo '';
    }
}
