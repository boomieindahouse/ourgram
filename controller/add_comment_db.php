<?php 
    session_start();
    include('connect.php');
    if(isset($_POST['comment_sb'])){
        $comment = $_POST['comment_txt'];
        $user_id = $_SESSION['user_login'];
        $post_id = $_POST['post_id'];
        $query = 'INSERT INTO comments (`comment`,`post_id`,`user_id`) 
        VALUES (:comment, :post_id, :user_id)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        header("location: /");
        exit;
    }

?>