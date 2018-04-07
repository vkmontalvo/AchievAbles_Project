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
        $userRewards = userRewards($_SESSION['user']);
        
        if (isGet()){
            $_SESSION['message'] = '';
            $action = filter_input(INPUT_GET, 'action');
            
            if (isset($action)){
                
            
            $column = filter_input(INPUT_GET, 'scolumn');
            $userRewards = sortByReward($_SESSION['user'],$column);
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
            <h2 class='header'>My Rewards</h2><br/><span class="success"><?php echo $_SESSION['message']?></span>
            <?php
            if($userRewards === true){
                echo "<div class='nogoals'><h3 class='summary'>No Rewards!</h3><br />"
                . "You don't have any rewards!<br />"
                        . "Click on the 'Add' button to get started!<br /><br />
                            <a href='addreward.php'><button class='add-goal'>Add +</button></a></div>";
            }
            else {
                echo "<div class='goal-view'><form method='get' name='sort' action='rewards.php'><select class='sort' name='scolumn' id='scolumn'>"
                . "<option value='cost'>Cost</option>"
                        . "<option value='reward_descrip'>Description</option>"
                        . "</select><input type='hidden' name='action' value='sort'>"
                        . "<button type='submit' class='sort-submit'>Sort</button></form>";
                foreach($userRewards as $row):
                    echo "<div class='rewards'><img src='" . $row['reward_img'] . "' class='goal-img-list' />"
                        . "<div class='goal-middle'>".$row['reward_descrip']."</div>"
            . "<div class='reward-buttons'><a href='buy.php?points=".$row['cost']."'><img src='images/buy.png' class='buy-button' /></a><a href='deletereward.php?id=".$row['reward_id']."'><img src='images/delete-sign.png' class='sml-button' /></a></div><div class='cost-block'><h5 class='cost'>cost</h5><br />" . $row['cost'] . "</div></div>";
                endforeach;
                echo "<br /><a href='addreward.php'><button class='add-goal' style='float:right;margin-right:40%;'>Add +</button></a></div>";
            }
            ?>
            
            </div>
            
     
        <footer class="foot">
            AchievAbles &copy; Valerie Montalvo, 2018
        </footer>
        <?php $_SESSION['message'] = ''; ?>
    </body>

</html>

