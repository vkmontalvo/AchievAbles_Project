<?php
// Start the session
session_start();

if (!$_SESSION['login']) {
    header('Location:index.php');
    die;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include './dbfunctions.php';
        $db = dbconnect();
        
        if (isGet()){
            $points = filter_input(INPUT_GET, 'points');
            $function = 'subtract';
            
            $newpoints=userPoints($_SESSION['user'], $points, $function);
            
            $_SESSION['points'] = $newpoints;
            
            header('location:rewards.php');
            exit;
        }
        ?>
    </body>
</html>