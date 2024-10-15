<?php 
   // include_once("connect.php");
    session_start();
    if(isset($_SESSION['user_login'])||isset($_SESSION['admin_login'])){
        header('location: /');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/auth.css">
    <link rel="stylesheet" href="/styles/header.css">
    <link rel="icon" type="image/png" sizes="32px" href="/assets/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
</head>

<body>
    <?php include("./component/header.php") ?>
    <div class="main container">
        <div class="main-lt">
            <form action='/signup_db' method='post'>
                <?php if(isset($_SESSION['error'])) { ?>
                    <div class="message error">
                        <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                    </div>
                 <?php } ?>
                 <?php if(isset($_SESSION['warning'])) { ?>
                    <div class="message warning">
                        <?php 
                            echo $_SESSION['warning'];
                            unset($_SESSION['warning']);
                        ?>
                    </div>
                 <?php } ?>    
                <div class="form-title">
                    <h1 class="blue-sub mb-1">Sign up</h1>
                    <p class="mb-1 lightgray">If you have an account? <span class="blue-sub"><a href="/signin">Sign in</a></span></p>
                    <p class="mb-1 lightgray">Enter your information to sign up.</p>
                </div>
                <div class="input-wrap">
                    <input type="text" placeholder="Username" name="username">
                </div>
                <div class="input-wrap">
                    <input type="email" placeholder="Email" name="email">
                </div>
                <div class="input-wrap password">
                    <input type="password" placeholder="Password" name="password">
                </div>
                <div class="input-wrap password mb-2">
                    <input type="password" placeholder="Confirm Password" name="cfpassword">
                </div>
                <input type="submit" name="signup"  value="Sign up" />
            </form>
        </div>
        <div class="main-rt">
            <div class="line">
                <img src="../assets/auth_img.png" alt="auth_img">
                <div class="py-2">
                    <h3>Welcome!</h3>
                    <p>Hope you guys happy with our platform.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>