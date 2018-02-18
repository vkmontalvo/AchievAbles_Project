<?php
// Start the session
session_start();
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
    <body class="main">
        <?php
        // Include database connections
        include './dbfunctions.php';
        $db = dbconnect();
        $message = "";
        ?>

        <!-- Bottom Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-bottom">
            <div class="container-fluid">
                <a href='index.php' class='links'>Home</a>
                <button class="links" id="contactUs">Contact Us</button>
                <a href='about.php'class="links">About Us</a>
            </div>

        </nav>

        <!-- Top Content & Buttons -->
        <div class="container-fluid">
            <img src="images/achieveables_logo.png" class="logo" />
            <button class="login" id="logIn">Login</button>
            <button class="signup" id="signUp">Sign Up</button>

            <!-- Sign Up Modal -->
            <div class="modal fade modalcstm" id="signupModal" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="signup-welcome">Hello</h4>
                            <p class="info">Welcome to AchievAbles!<br>
                                Enter your information below to get started.</p>
                        </div>
                        <div class="modal-body">
                            <form role="form" id='signupForm'>
                                <div class="form-group">
                                    <input type="text" onblur="usernameValidate()" class="form-control" id="usrname1" placeholder="Username">
                                    <span class="error" id="usrerror1"></span>
                                </div>
                                <div class="form-group">
                                    <input type="email" onblur="emailValidate()" class="form-control" id="email1" placeholder="Email">
                                    <span class="error" id="email1-error"></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" onblur="passValidate()" class="form-control" id="passwrd1" placeholder="Password">
                                    <span class="error" id="passerror1"></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" onkeyup="confirmValid()" class="form-control" id="passwrdCfrm1" placeholder="Confirm Password">
                                    <span class="error" id="passconfirmerror"></span>
                                </div>
                                <button type="submit" class="submitbtn" id='signup-submit' onclick='signUpSubmit()'>Submit</button>           
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p class="small-info">By signing up, you agree to our<br>
                                <a href="#">Terms & Conditions</a></p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Login Modal -->
            <div class="modal fade modalcstm" id="loginModal" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="signup-welcome">Welcome Back</h4>
                            <p class="info">Good to see you!<br>
                                Let's get back to business.</p>
                        </div>
                        <div class="modal-body">
                            <form role="form" action='index.php' method='post'>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="usrname" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="passwrd" placeholder="Password">
                                </div>
                                <button type="submit" class="submitbtn" name='login-submit'>Submit</button>           
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p class="small-info"><a href="#">Forgot Username or Password?</a></p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Contact Modal -->
            <div class="modal fade modalcstm" id="contactModal" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="signup-welcome">We're Here to Help</h4>
                            <p class="info">Having trouble or want to know more?<br>
                                Send us a message and we'll contact you asap.</p>
                        </div>
                        <div class="modal-body">
                            <form role="form" action='index.php' method='post'>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="emailadd" placeholder="Your Email">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control message-box" name="message" placeholder="Message"></textarea>
                                </div>
                                <button type="submit" class="submitbtn" name='message-submit'>Submit</button>           
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p class="small-info">Please allow up to 48 hrs for a response.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        if (isPost()) {
            //================================================================
            // Sign Up Form
            //================================================================
            // If the Sign Up form was submitted, gather user input
            if(isset($_POST['signup-submit'])){
                $user = filter_input(INPUT_POST, 'usrname');
                $email = filter_input(INPUT_POST, 'email');
                $pwd = filter_input(INPUT_POST, 'passwrd');
                $pwdconfirm = filter_input(INPUT_POST, 'passwrdCfrm');
                
                // If the passwords do not match, show an error
                if ($pwd !== $pwdconfirm){
                    $pwdmessage = "Passwords do not match!";
                }
                
                // Else, check if the username exists
                else {
                    $existingUser = checkUsername($user);
                    
                    // If the username exists, show an error
                    if ($existingUser === true){
                        $usrmessage = "Username exists. Please choose another one.";
                    }
                    
                    // Else, add the user to the database
                    else {
                        $group = "User";
                        $salt = 'B3li3v3';
                        $sha = sha1($salt . $pwd); 
                        $success = addUser($user, $email, $sha, $group);
                        
                        // If the user is successfully added, log them in
                        if ($success === true) {
                            $login = login($user, $sha);
                        
                            // If the user successgully logs in, redirect to the user dashboard page and start session
                            if ($login === true) {
                                $_SESSION['user'] = $user;
                        
                                header('Location:userdash.php');
                            }
                            
                            // If the user is not successfully logged in, show error
                            else {
                                $error = "An error has occured. Please try again later.";
                            }
                        }
                        
                        // if the user was not successfully added to the database, show error
                        else {
                            $error = "An error has occured. Please try again later.";
                        }
                    }
                }
            }
            
            //================================================================
            // Login Form
            //================================================================
            // If the Sign Up form was submitted, gather user input
            if (isset($_POST['login-submit'])){
                $user = filter_input(INPUT_POST, 'usrname');
                $pwd = filter_input(INPUT_POST, 'passwrd');
                $salt = 'B3li3v3';
                $sha = sha1($salt . $pwd);
                
                $login = login($user,$sha);
                
                // If successfully logged in, start session
                if ($login === true){
                    $_SESSION['user'] = $user;
                    $admin = groupValidate($user);
                    
                    // If admin user, send to admin dashboard. Else, send to user dashboard
                    if ($admin === true){
                        header('Location:admindash.php');
                    }
                    else {
                        header('Location:userdash.php');
                    }
                }
                
                // If unsuccessful login, show error
                else {
                    $loginerror = "Incorrect username or password.";
                }
            }
            
            //================================================================
            // Contact Form
            //================================================================
            if (isset($_POST['message-submit'])){
                $email = filter_input (INPUT_POST, 'emailadd');
                $subject = filter_input(INPUT_POST, 'subject');
                $msg = wordwrap(filter_input(INPUT_POST, 'message'), 70);
                
                
                mail("valeriekmontalvo@gmail.com","New AchievAbles Message: " . $subject,$msg, "From: " . $email);
            }
        }
        ?>
        <?php echo $message; ?>
        
    </body>
</html>
