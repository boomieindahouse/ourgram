<?php 
    include("connect.php");
    $query = "SELECT user_id, username, email, profile_name, create_at
        FROM users 
        WHERE role != 'admin' 
        ORDER BY user_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    password_hash($rows['password'], PASSWORD_DEFAULT);
    header('Content-Type: application/json');
  
     echo json_encode($rows);

    
?>