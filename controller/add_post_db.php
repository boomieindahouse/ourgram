<?php
session_start();

include('connect.php');
if (isset($_POST['addpost'])) {
    $post_txt = $_POST['post_txt'];
    //print_r($_FILES['imgInp']['name']);
    if (empty($post_txt)) {
        $_SESSION['error'] = "Plase enter your text";
        header("location: /");
        exit;
    } else if (count($_FILES['imgInp']) <= 0) {
        $_SESSION['error'] = "Please include at least one picture.";
        header("location: /");
        exit;
    } else if (!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = "No authentification!";
    } else {
        try {

            $user_id = $_SESSION['user_login'];
            $sql_post = $conn->prepare('INSERT INTO posts (`caption`, `user_id`) VALUES (:caption, :user_id)');
            $sql_post->bindParam(':caption', $post_txt);
            $sql_post->bindParam(':user_id', $user_id);
            $sql_post->execute();
            if (isset($sql_post)) {
                $post_id = $conn->lastInsertId();
                mkdir('uploads/posts/' . $post_id, 0777);
                $folderPath = 'uploads/posts/' .$post_id;

                foreach($_FILES['imgInp']['error'] as $key => $error){
                    if($error == UPLOAD_ERR_OK){
                        $tmp_name = $_FILES['imgInp']['tmp_name'][$key];
                        $name = basename($_FILES['imgInp']['name'][$key]);
                        move_uploaded_file($tmp_name, "$folderPath/$name");
                    }
                }
                $sql_media = $conn->prepare('INSERT INTO posts_media (`post_id`, `media_files`) 
                VALUES (:post_id, :media_files)');
                $media_files = json_encode($_FILES['imgInp']['name']);
                $sql_media->bindParam(':post_id', $post_id);
                $sql_media->bindParam(':media_files', $media_files);
                $sql_media->execute();
                header("location: /");
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
