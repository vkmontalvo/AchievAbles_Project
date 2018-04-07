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
            $id = filter_input(INPUT_GET, 'id');
            $_SESSION['goal'] = $id;
            
            
            
            $goal = viewGoal($id);
            $tasks = goalTasks($id);
            updateProgress($_SESSION['goal']);
        }
        
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
            <div class="goalview">
            <img src="<?php echo $goal['goal_img']; ?>" class="goal-img-view" /><br /><br />
            <h2 class='goal-header'><?php echo $goal['goal_title']; ?></h2><?php echo '<a href="editgoal.php?id=' . $goal['goal_id'] . '">'; ?><img src="images/edit.png" class="edit-goal" alt="Edit" /><?php echo '</a>'; ?>
            <br/><h4 class="cat-header"><?php echo $goal['category']; ?></h4><h4 class="progress-header"><?php echo $goal['progress']; ?>%</h4><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            <p class="goal-descrip"><?php echo $goal['goal_descrip']; ?></p><br /><br /><span class="success"><?php echo $_SESSION['message']?></span>
            <br/>
            <?php
            if($tasks === true){
                echo "<div class='nogoals'><h3 class='summary'>No Tasks!</h3><br />"
                . "You don't have any tasks for this goal!<br />"
                        . "Click on the 'Add' button to get started!<br /><br />
                            <a href='addtask.php?id=".$id."'><button class='add-goal'>Add +</button></a></div>";
            }
            else {
                foreach($tasks as $row):
                    echo "<div class='tasks'>"
                        . "<div class='task-left-content'><h5 class='pnts'>pts</h5><br /><h3 class='task-pnts'>" . $row['points'] . "</h3><br />"
                        . "</div><div class='task-middle'>".$row['task_descrip']."</div><div class='task-buttons'><a href='addpoints.php?points=".$row['points']."'><img src='images/check.png' class='sml-button' /></a><a href='deletetask.php?id=".$row['task_id']."'><img src='images/delete-sign.png' class='sml-button' /></a>"
            . "</div></div><br />";
                endforeach;
                echo "<br /><a href='addtask.php?id=".$row['goal_id']."'><button class='add-goal' style='float:right;'>Add +</button></a></div>";
            }
            ?>
            
            </div>
            </div>
            
     
        <footer class="foot">
            AchievAbles &copy; Valerie Montalvo, 2018
        </footer>
        <?php $_SESSION['message'] = ''; ?>
    </body>

</html>

