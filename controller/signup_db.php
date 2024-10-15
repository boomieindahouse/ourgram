<?php
session_start();
include('connect.php');
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];
    $role = 'user';

    if (empty($username)) {
        $_SESSION['error'] = 'Please enter your username';
        header("location: /signup");
        exit;
    } else if (empty($email)) {
        $_SESSION['error'] = 'Please enter your email';
        header("location: /signup");
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Password Pattern not invalid';
        header("location: /signup");
        exit;
    } else if (empty($password)) {
        $_SESSION['error'] = 'Please enter your password';
        header("location: /signup");
        exit;
    } else if (empty($cfpassword)) {
        $_SESSION['error'] = 'Please enter your confirm password';
        header("location: /signup");
        exit;
    } else if (strlen($_POST['password']) < 6) {
        $_SESSION['error'] = 'Password length must higher or equal 6';
        header("location: /signup");
        exit;
    } else if ($password !== $cfpassword) {
        $_SESSION['error'] = 'Password and Confirm password is not match';
        header("location: /signup");
        exit;
    } else {
        try {
            $check_email = $conn->prepare('SELECT email FROM users WHERE email = :email');
            $check_email->bindParam(":email", $email, PDO::PARAM_STR);
            $check_email->execute();
            $row = $check_email->fetch(PDO::FETCH_ASSOC);

            if ($row['email'] == $email) {
                $_SESSION['warning'] = "This email is already used";
                header("location: /signup");
                exit;
            } else if (!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $sql = 'INSERT INTO users (`username`, `email`, `password`, `role`, `profile_name`) 
                    VALUES (:username, :email, :password, :role, :profile_name)';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                $stmt->bindParam(':profile_name', $username, PDO::PARAM_STR);
                $stmt->execute();
                $_SESSION['success'] = "Register succesfully";
                header("location: /signin");
                exit;
            } else {
                $_SESSION['error'] = "Something wrong";
                header("location: /signup");
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
