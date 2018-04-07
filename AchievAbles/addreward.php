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
        
        if (isPost()) {
                // Form Variables
                $img = filter_input(INPUT_POST, 'image');
                $cost = filter_input(INPUT_POST, 'cost');
                $description = filter_input(INPUT_POST,'descrip');
                
                if ($img === ''){
                    $img = "images/reward.png";
                }

                addReward($_SESSION['user'],$cost,$description,$img);
                
                $_SESSION['message'] = 'Reward added!';
                header('location:rewards.php');
                exit;
            }
            
            else {
            
            }
            ?>
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
            <br />
            <br />
            <br />
            <form method="post" action="addreward.php">
            <div class="goal">
                <div class="left-content">
                    <img src="images/reward.png" class="goal-img" /><br />
                    <label for ="image" class="labels">Image URL</label><br />
                    <input type="text" name="image" class="img-entry" />
                    
                </div>
                <div class="goal-content">
                    
                    <label for="cost" class="labels">Cost</label><br />
                    <input type="text" name="cost" class="edit-entries"/><br />
                    <label for="descrip" class='labels'>Description</label><br />
                    <textarea name='descrip' class='text-area'></textarea><br />
                    <button type="submit" class="goal-submit">Submit</button>
                    <a href="rewards.php"><button type="button" class="cancel"><u>Cancel</u></button></a>
                        
                </div>
            </div>
            </form>
            
        </div>
        <footer class="foot">
            AchievAbles &copy; Valerie Montalvo, 2018
        </footer>
    </body>

</html>

