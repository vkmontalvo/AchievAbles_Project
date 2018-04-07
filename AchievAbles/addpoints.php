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
            $function = 'add';
            
            $newpoints=userPoints($_SESSION['user'], $points, $function);
            
            $_SESSION['points'] = $newpoints;
            
            header('location:viewgoal.php?id='.$_SESSION['goal']);
            exit;
        }
        ?>
    </body>
</html>
