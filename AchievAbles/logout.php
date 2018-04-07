<?php

session_start();

if ($_POST['logout']){
   // Destroy the session 
session_destroy(); 

// Redirect to login page
header('Location:index.php');
exit; 

}


