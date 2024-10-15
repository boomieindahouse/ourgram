<?php 
    include("connect.php");
    $query = "     
    SELECT p.post_id, p.caption, p.create_at, p.user_id,
    u.username, u.profile_name ,u.profile_pic, 
    pm.media_files
    FROM posts AS p INNER JOIN users AS u
    ON p.user_id = u.user_id
    LEFT OUTER JOIN posts_media AS pm
    ON pm.post_id = p.post_id
    ORDER BY p.post_id;";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    header('Content-Type: application/json');
  
    echo json_encode($rows);
