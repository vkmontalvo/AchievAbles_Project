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
            $id = filter_input(INPUT_GET, 'id');
            
            deleteTask($id);
            
            header('location:viewgoal.php?id='.$_SESSION['goal']);
            exit;
        }
        ?>
    </body>
</html>
