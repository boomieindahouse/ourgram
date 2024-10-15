<?php
    //include_once("connect.php");
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
    <title>sign in</title>
</head>

<body>
    <?php include("./component/header.php") ?>
    <div class="main container">
        <div class="main-lt">
            <form action="/signin_db" method="post">
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="message error">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['warning'])) { ?>
                    <div class="message warning">
                        <?php
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                        ?>
                    </div>
                <?php } ?>
                <div class="form-title">
                    <h1 class="blue-sub mb-1">Sign in</h1>
                    <p class="mb-1 lightgray">Don't have an account? <span class="blue-sub"><a href="/signup">Create an account</a></span></p>
                    <p class="mb-1 lightgray">It will take less than a minute.</p>
                </div>
                <div class="input-wrap">
                    <input type="email" placeholder="Email" name="email">
                </div>
                <div class="input-wrap password mb-2">
                    <input type="password" placeholder="Password" name="password">
                </div>
                <input type="submit" name="signin" value="Sign in" />
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