<?php
include('connect.php');

if (isset($_POST['action'])) {
    if ($_POST['action'] == "fetch_user") {
        $user_id = $_POST['user_id'];
        $sql = "SELECT user_id,username,profile_name,bio,email,password FROM users WHERE user_id = $user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $json = json_encode($row);
        header('Content-Type: application/json');
        echo $json;
    } else if ($_POST['action'] == "delete_user") {
        $user_id = $_POST['user_id'];

        $query = "
        DELETE u
        FROM users AS u 
        WHERE user_id = $user_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $query2 = "
            DELETE f
            FROM followers AS f
            WHERE f.following_user_id = $user_id
            ";
        $stmt2 = $conn->prepare($query2);
        $stmt2->execute();

        $query3 = "
            DELETE l
            FROM likes AS l
            WHERE l.user_id = $user_id
            ";
        $stmt3 = $conn->prepare($query3);
        $stmt3->execute();

        //ลบไฟล์ user

        header("location:  /admin/users");
        exit;
    } else if ($_POST['action'] == "delete_post") {
        $post_id = $_POST['post_id'];

        $query = "DELETE FROM posts AS p WHERE p.post_id = $post_id";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $query2 = "
        DELETE l
        FROM likes AS l
        WHERE l.post_id = $post_id
        ";
        $stmt2 = $conn->prepare($query2);
        $stmt2->execute();

        //ลบไฟล์โพสต์ 


        header("location:  /admin/posts");
        exit;
    } else if ($_POST['action'] == 'fetch_post') {
        $post_id = $_POST['post_id'];

        $query = "SELECT p.post_id, p.caption, p.create_at, p.user_id, 
        pm.media_files, u.username
        FROM posts AS p 
        NATURAL JOIN posts_media AS pm
        INNER JOIN users AS u
        ON p.user_id = u.user_id
        WHERE p.post_id = $post_id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');

        echo json_encode($rows);
    }
} else if (isset($_POST['edit_user'])) {
    $username = $_POST['username'];
    $profile_name = $_POST['profile_name'];
    $bio = $_POST['bio'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_id = $_POST['user_id'];

    if (empty($username)) {
        $_SESSION['error'] = 'Username empty';
        header("location:  /admin/users");
        exit;
    } else if (empty($email)) {
        $_SESSION['error'] = 'Email empty';
        header("location:  /admin/users");
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Email Pattern not invalid';
        header("location:  /admin/users");
        exit;
    } else if (strlen($bio) > 150) {
        $_SESSION['error'] = 'bio too long';
        header("location: /admin/users");
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
                header("location: /admin/users");
                exit;
            } else if ($row_username['username'] == $username) {
                $_SESSION['warning'] = "This username is already used";
                header("location: /admin/users");
                exit;
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $query = 'UPDATE users SET username = :username, 
                email=:email, profile_name=:profile_name, bio=:bio
                WHERE user_id = :user_id';
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                //   $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':profile_name', $profile_name, PDO::PARAM_STR);
                $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
                $stmt->execute();
                $_SESSION['success'] = "Account be updated successfully";
                header("location:  /admin/users");
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else if (isset($_POST['edit_post'])) {
    $post_id = $_POST['post_id'];
    $caption = $_POST['caption'];

    $query = "UPDATE posts SET caption = '$caption' WHERE post_id = $post_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    header("location:  /admin/posts");
    exit;
}
