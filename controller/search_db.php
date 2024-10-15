<?php 
    include('connect.php');
    if(isset($_POST['action'])){
        if($_POST['action']=="username"){
            $value = $_POST['value'];
            $sql = "SELECT u.user_id, u.username, u.profile_pic
            FROM users AS u WHERE u.username LIKE '%$value%'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $json = json_encode($row);
            header('Content-Type: application/json');
            echo $json;
        }else if($_POST['action']=="admin_search_users"){
            $value = $_POST['value'];
            $sql = "SELECT * 
            FROM users AS u 
            WHERE u.username LIKE '%$value%' OR u.email LIKE '%$value%'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $json = json_encode($row);
            header('Content-Type: application/json');
            echo $json;
        }else if($_POST['action']=="admin_search_posts"){
            $value = $_POST['value'];
            $sql = "
            SELECT DISTINCT p.post_id, p.caption, p.create_at, p.user_id,
            u.username, u.profile_name ,u.profile_pic, 
            pm.media_files
            FROM posts AS p INNER JOIN users AS u
            ON p.user_id = u.user_id
            LEFT OUTER JOIN followers AS flw
            ON flw.following_user_id = p.user_id
            LEFT OUTER JOIN posts_media AS pm
            ON pm.post_id = p.post_id
            WHERE u.username LIKE '%$value%' OR u.email LIKE '%$value%' 
            OR p.caption LIKE '%$value%'
            ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $json = json_encode($row);
            header('Content-Type: application/json');
            echo $json;
        }
    }
?>