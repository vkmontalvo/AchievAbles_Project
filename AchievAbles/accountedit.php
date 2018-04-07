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
        <title>AchievAbles</title>
    </head>
    <body class="landing">
        <?php
// Include database connections
        include './dbfunctions.php';
        $db = dbconnect();
        $userarray = userInfo($_SESSION['user']);
        
        if (isPost()) {
                // Form Variables
                $email = filter_input(INPUT_POST, 'email');
                $pwd = filter_input(INPUT_POST, 'passwrd');
                $img = filter_input(INPUT_POST, 'user-image');

                $message = updateUser($_SESSION['user'],$email,$pwd,$img);
                
                $_SESSION['message'] = 'Account updated!';
                header('location:account.php');
                exit;
            }
            
            else {
            $email = $userarray['email'];
            $img = $userarray['user_img'];
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
            <h2 class='header'>My Account</h2><br/><span class="edit-error" id="edit-error"></span>
            <form method="post" action="accountedit.php">
            <div class="account">
                <div class="left-content">
                    <img src="<?php echo $_SESSION['img'] ?>" class="acct-img" />
                    <h4 class="username" style="margin-bottom:1px;"><?php echo $_SESSION['user'] ?></h4>
                    <label for ="user-image" class="labels">Image URL</label><br />
                    <input type="text" name="user-image" class="img-entry" value="<?php echo $img ?>" />
                    
                </div>
                <div class="middle-content-edit">
                    
                    <label for="email" class="labels">Email Address</label><br />
                    <input type="text" name="email" id="email" onchange="emailCheck()" class="edit-entries" value="<?php echo $email ?>" /><br/><br/>
                    <label for="passwrd" class="labels">Password</label><br />
                    <input type="password" name="passwrd" id="passwrd" class="edit-entries" oninput="passCheck()"/>
                </div>
                <div class="right-content-edit">
                    <label for="email-conf" class="labels">Confirm Email</label><br />
                    <input type="text" name="email-conf" id="email-conf" class="edit-entries" oninput="emailCheck()"/><br/><br/>
                    <label for="passwrd-conf" class="labels">Confirm Password</label><br/>
                    <input type="password" name="passwrd-conf" id="passwrd-conf" class="edit-entries" oninput="passCheck()"/><br/>
                    <button type="button" class="delete" id="deleteAccount" data-target="#deleteModal"><u>Delete Account</u></button>
                    <button type="submit" class="submit-edit" id="submit-edit">Submit</button>
                </div>
            </div>
            </form>
            <!-- Delete Account Modal -->
            <div class="modal fade modalcstm" id="deleteModal" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="signup-welcome">Are you sure?</h4>
                            <p class="info">All of your user data, including goal progress, will be deleted.<br />
                                This action cannot be undone.</p>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="loginForm" method="post" action="delete.php">
                                <div class="form-group">
                                    <span class="error" id="delete-error"></span>
                                    <input type="text" class="form-control" name="user2" id="user2" placeholder="Username"><br />
                                    <input type="password" class="form-control" name="passwrd2" id="passwrd2" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-danger" name='delete-submit' id="delete-submit">Delete My Account</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <footer class="foot">
            AchievAbles &copy; Valerie Montalvo, 2018
        </footer>
    </body>

</html>

