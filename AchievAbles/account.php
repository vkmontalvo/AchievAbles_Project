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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="main.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="main.css">
        <title>AchievAbles</title>
    </head>
    <body class="landing">
        <?php
// Include database connections
        include './dbfunctions.php';
        $db = dbconnect();

        $userarray = userInfo($_SESSION['user']);
        $lastLogin = lastLogin($_SESSION['user']);
        $complete = countGoals($_SESSION['user'], 'complete');
        $inprogress = countGoals($_SESSION['user'], 'inprogress');
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
            <h2 class='header'>My Account</h2><?php echo '<a href="accountedit.php?id=' . $userarray['user_id'] . '">'; ?><img src="images/edit.png" class="edit" alt="Edit" /><?php echo '</a>'; ?>
            <br /><span class="success"><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];}?></span>
            <div class="account">
                <div class="left-content">
                    <img src="<?php echo $_SESSION['img'] ?>" class="acct-img" />
                    <h4 class="username" style="margin-bottom:1px;"><?php echo $_SESSION['user'] ?></h4>
                    <?php echo $userarray['email'] ?><br /><br />
                    account created<br /><?php echo $userarray['account_created'] ?>
                    <br /><br />
                    last login<br /><?php echo max($lastLogin) ?> 
                </div>
                <div class="middle-content">
                    <h4 class="summary">Goals Summary</h4><br />
                    <h4 class="goal-head">achieved</h4><h4 class="goal-head" style="margin-left:12%;">in progress</h4><br />
                    <h1 class="goal-count"><?php echo $complete['count']; ?></h1><h1 class="goal-count" style="margin-left:40%;"><?php echo $inprogress['count']; ?></h1>   
                </div>
                <div class="right-content">
                    <h4 class="score-head">Score</h4><br />
                    <h1 class="goal-count"><?php echo $_SESSION['points'] ?></h1><h6 class="pnts">pts</h6><br />
                    <button class="logout" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
        <footer class="foot">
            AchievAbles &copy; Valerie Montalvo, 2018
        </footer>
        <?php $_SESSION['message'] = ''; ?>
    </body>

</html>