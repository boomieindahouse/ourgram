<?php 
    session_start();
    include('connect.php');
    
    if(isset($_POST['action'])){
        $user_id = $_SESSION['user_login'];
        $post_id = $_POST['post_id'];
        $output;
        if($_POST['action']=='like'){
            $sql_ch_l = "SELECT * FROM likes AS l WHERE l.post_id = $post_id AND l.user_id = $user_id";
            $check_like = $conn->prepare($sql_ch_l);
            $check_like->execute();
            $row_ch = $check_like->rowCount();
            if($row_ch == 1){
                $sql = "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $sql2 = "SELECT COUNT(post_id) FROM likes WHERE post_id = $post_id";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
                $count = $stmt2->fetch(PDO::FETCH_ASSOC);
                $output = implode($count);
            }else{
                $sql = "INSERT INTO likes (`user_id`, `post_id`) VALUES ($user_id, $post_id)";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $sql2 = "SELECT COUNT(post_id) FROM likes WHERE post_id = $post_id";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
                $count = $stmt2->fetch(PDO::FETCH_ASSOC);
                $output = implode($count);
            }
        }else if($_POST['action']=='unlike'){
            $sql = "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $sql2 = "SELECT COUNT(post_id) FROM likes WHERE post_id = $post_id";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
            $count = $stmt2->fetch(PDO::FETCH_ASSOC);
            $output = implode($count);
        }
        echo $output;
        
    }

