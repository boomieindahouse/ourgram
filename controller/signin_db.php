<?php
include('connect.php');
session_start();
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $_SESSION['error'] = 'Please enter your email';
        header("location: /signin");
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Password Pattern not invalid';
        header("location: /signin");
        exit;
    } else if (empty($password)) {
        $_SESSION['error'] = 'Please enter your password';
        header("location: /signin");
        exit;
    } else if (strlen($_POST['password']) < 6) {
        $_SESSION['error'] = 'Password length must higher or equal 6';
        header("location: /signin");
        exit;
    } else {
        try {
            $check_data = $conn->prepare('SELECT * FROM users WHERE email = :email');
            $check_data->bindParam(":email", $email, PDO::PARAM_STR);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($email == $row['email']) {
                    if (password_verify($password, $row['password'])) {
                        if ($row['role'] == 'admin') {
                            $_SESSION['admin_login'] = $row['user_id'];
                            header("location: /admin/dashboard");
                            exit;
                        } else {
                            $_SESSION['user_login'] = $row['user_id'];
                            header("location: /");
                            exit;
                        }
                    } else {
                        $_SESSION['error'] = "Password Wrong";
                        header("location: /signin");
                        exit;
                    }
                }
            } else {
                $_SESSION['warning'] = "No Account";
                header("location: /signin");
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
