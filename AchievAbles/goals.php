<?php
// Start the session
session_start();

if (!$_SESSION['login']) {
    header('Location:index.php');
    die;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="main.js"></script>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="goals.css">
        <title>AchievAbles</title>
    </head>
    <body class="landing">
        <?php
// Include database connections
        include './dbfunctions.php';
        $db = dbconnect();
        $userGoals = userGoals($_SESSION['user']);
        
        if (isGet()){
            $_SESSION['message'] = '';
            $action = filter_input(INPUT_GET, 'action');
            
            if (isset($action)){
                
            
            $column = filter_input(INPUT_GET, 'scolumn');
            $userGoals = sortBy($_SESSION['user'],$column);
        }}
        
            ?>
        

        <!-- Top Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <img src="images/achieveables_logo.png" class="achieve-logo" />
                <ul>
                    <li class="inside-links"><a href="userdash.php">Dashboard</a></li>
                    <li class="inside-links"><a href="goals.php">Goals</a></li>
                    <li class="inside-links"><a href="rewards.php">Rewards</a></li>
                </ul>
                <div class='user'><a href='account.php'><img src="<?php echo $_SESSION['img'] ?>" class='user-img'/></a></div>
                <div class="user2">
                    <p class="username"><?php echo $_SESSION['user'] ?></p>
                    <h4 class="points"><?php echo $_SESSION['points'] ?></h4></div>

            </div>
        </nav>

        <img src="images/toa-heftiba-464644.jpg" class="banner" />
        <div class='container-fluid'>
            <h2 class='header'>My Goals</h2><br/><span class="success"><?php echo $_SESSION['message']?></span>
            <?php
            if($userGoals === true){
                echo "<div class='nogoals'><h3 class='summary'>No Goals!</h3><br />"
                . "You don't have any goals to work on!<br />"
                        . "Click on the 'Add' button to get started!<br /><br />
                            <a href='addgoal.php'><button class='add-goal'>Add +</button></a></div>";
            }
            else {
                echo "<div class='goal-view'><form method='get' name='sort' action='goals.php'><select class='sort' name='scolumn' id='scolumn'>"
                . "<option value='goal_title'>Title</option>"
                        . "<option value='category'>Category</option>"
                        . "<option value='progress'>Progress</option>"
                        . "</select><input type='hidden' name='action' value='sort'>"
                        . "<button type='submit' class='sort-submit'>Sort</button></form>";
                foreach($userGoals as $row):
                    echo "<a href='viewgoal.php?id=" . $row['goal_id'] . "'><div class='goals'><img src='" . $row['goal_img'] . "' class='goal-img-list' />"
                        . "<div class='goal-title-block'><h3 class='goal-title'>" . $row['goal_title'] . "</h3><br />"
                        . "<h4 class='goal-cat'>" . $row['category'] . "</h4></div><div class='goal-middle'>".$row['goal_descrip']."</div>"
            . "<div class='progress-block'>" . $row['progress'] . "%</div></div></a>";
                endforeach;
                echo "<br /><a href='addgoal.php'><button class='add-goal' style='float:right;margin-right:40%;'>Add +</button></a></div>";
            }
            ?>
            
            </div>
            
     
        <footer class="foot">
            AchievAbles &copy; Valerie Montalvo, 2018
        </footer>
        <?php $_SESSION['message'] = ''; ?>
    </body>

</html>

