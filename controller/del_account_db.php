<?php
    include('connect.php');
    session_start();
    if(isset($_POST['del'])){
        $user_id = $_SESSION['user_login'];
        $passwrd_txt = $_POST['password_txt'];
        
        $check_pass = $conn->prepare('SELECT password FROM users WHERE user_id = :user_id');
        $check_pass->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $check_pass->execute();
        $row = $check_pass->fetch(PDO::FETCH_ASSOC);
        //ยังไม่เสร็จต้อง join table ทั้งหมด แล้วลบ
        if(password_verify($passwrd_txt, $row['password'])){
            $query6 = "
        DELETE nt
        FROM notifications AS nt
        WHERE nt.user_id = $user_id
        ";
        $stmt6 = $conn->prepare($query6);
        $stmt6->execute();
       
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

        $query4 = "
        DELETE cm
        FROM comments AS cm
        WHERE cm.user_id = $user_id
        ";
        $stmt4 = $conn->prepare($query4);
        $stmt4->execute();

        $query7 = "
        DELETE pm 
        FROM posts_media AS pm, posts AS p
        WHERE pm.post_id = p.post_id && p.user_id = $user_id

        ";
        $stmt7 = $conn->prepare($query7);
        $stmt7->execute();


        $query8 = "
        DELETE p 
        FROM posts AS p WHERE p.user_id = $user_id
        ";
        $stmt8 = $conn->prepare($query8);
        $stmt8->execute();

        $query = "
        DELETE u
        FROM users AS u 
        WHERE user_id = $user_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        

        header("Refresh:0; url=/admin/users");
        exit;
    }elseif($_POST['action'] == 'delete_post'){
        $post_id = $_POST['post_id'];
        $query2 = "
        DELETE l
        FROM likes AS l
        WHERE l.post_id = $post_id;
        ";
        $stmt2 = $conn->prepare($query2);
        $stmt2->execute();

        $query3 = "
        DELETE cm
        FROM comments AS cm
        WHERE cm.post_id = $post_id;
        ";
        $stmt3 = $conn->prepare($query3);
        $stmt3->execute();

        $query4 = "
        DELETE pm
        FROM posts_media AS pm
        WHERE pm.post_id = $post_id;
        ";
        $stmt4 = $conn->prepare($query4);
        $stmt4->execute();
        $query = "
        DELETE p,pm,cm,l
        FROM posts AS p
        LEFT JOIN posts_media AS pm
        ON p.post_id = pm.post_id
        LEFT JOIN comments AS cm
        ON p.post_id = cm.post_id
        LEFT JOIN likes AS l
        ON p.post_id = l.post_id
        WHERE p.post_id = $post_id;
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute();

            $query2 = "
            DELETE l
            FROM likes AS l
            WHERE l.post_id = $post_id;
            ";
            $stmt2 = $conn->prepare($query2);
            $stmt2->execute();

            $query3 = "
            DELETE cm
            FROM comments AS cm
            WHERE cm.post_id = $post_id;
            ";
            $stmt3 = $conn->prepare($query3);
            $stmt3->execute();

            $query4 = "
            DELETE pm
            FROM posts_media AS pm
            WHERE pm.post_id = $post_id;
            ";
            $stmt4 = $conn->prepare($query4);
            $stmt4->execute();

            unset($_SESSION['user_login']);
            header("location: /");
            exit;
        }else{
            $_SESSION['warning'] = "Password is not match!";
            header("location: /");
            exit;
        }
    }
