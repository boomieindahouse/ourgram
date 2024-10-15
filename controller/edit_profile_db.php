<?php
session_start();
include('connect.php');

   print_r($_POST);
    if (isset($_POST['editprofile'])) {
        $username = $_POST['username'];
        $profile_name = $_POST['profile_name'];
        $bio = $_POST['bio'];
        $email = $_POST['email'];
        $user_id = $_SESSION['user_login'];

        if (empty($username)) {
            $_SESSION['error'] = 'Username empty';
            header("location: /acounts/edit");
            exit;
        } else if (empty($email)) {
            $_SESSION['error'] = 'Username empty';
            header("location: /acounts/edit");
            exit;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email Pattern not invalid';
            header("location: /acounts/edit");
            exit;
        } else if (strlen($bio) > 150) {
            $_SESSION['error'] = 'too long bio';
            header("location: /acounts/edit");
            exit;
        } else {
            try {
                $check_email = $conn->prepare('SELECT email FROM users WHERE email = :email AND user_id != :user_id');
                $check_email->bindParam(':email', $email, PDO::PARAM_STR);
                $check_email->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $check_email->execute();
                $row_email = $check_email->fetch(PDO::FETCH_ASSOC);

                $check_username = $conn->prepare('SELECT username FROM users WHERE username = :username AND user_id != :user_id');
                $check_username->bindParam(':username', $username, PDO::PARAM_STR);
                $check_username->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $check_username->execute();
                $row_username = $check_username->fetch(PDO::FETCH_ASSOC);

                if ($row_email['email'] == $email) {
                    $_SESSION['warning'] = "This email is already used";
                    header("location: /acounts/edit");
                    exit;
                } else if ($row_username['username'] == $username) {
                    $_SESSION['warning'] = "This username is already used";
                    header("location: /acounts/edit");
                    exit;
                } else {
                    $query = 'UPDATE users SET username = :username, 
                email=:email, profile_name=:profile_name, bio=:bio
                WHERE user_id = :user_id';
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':profile_name', $profile_name, PDO::PARAM_STR);
                    $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
                    $stmt->execute();
                    $_SESSION['success'] = "Account be updated successfully";
                    header("location: /acounts/edit");
                    exit;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }else if ($_POST['action'] == 'ch_profile') {
        $folderPath = 'uploads/avatar/';
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $user_id = $_SESSION['user_login'];

        $check_profile_pic = $conn->prepare('SELECT profile_pic FROM users WHERE user_id = :user_id AND profile_pic IS NOT NULL');
        $check_profile_pic->bindParam(':user_id', $user_id, PDO::FETCH_ASSOC);
        $check_profile_pic->execute();

        $row_profile_pic = $check_profile_pic->fetch(PDO::FETCH_ASSOC);
        if (isset($row_profile_pic['profile_pic'])) {
            $file_link = $folderPath . $row_profile_pic['profile_pic'];
            unlink($file_link);
        }
        $typefile = pathinfo($fileName, PATHINFO_EXTENSION);
        $tmp_name = $file['tmp_name'];
        $new_file_name = $user_id . '.' . $typefile;

        move_uploaded_file($tmp_name, "$folderPath/$new_file_name");

        $query = 'UPDATE users SET profile_pic=:profile_pic 
       WHERE user_id = :user_id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':profile_pic', $new_file_name, PDO::PARAM_STR);
        $stmt->execute();
        echo $folderPath . $new_file_name;
        exit;
    }

?>