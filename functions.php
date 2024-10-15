<?php
function count_following($conn, $user_id)
{
    $following_info = $conn->prepare("SELECT COUNT(following_user_id) FROM followers 
    WHERE following_user_id = $user_id");
    $following_info->execute();
    $row = $following_info->fetch(PDO::FETCH_ASSOC);
    return implode($row);
}
function count_followed($conn, $user_id)
{
    $followed_info = $conn->prepare("SELECT COUNT(followed_user_id) FROM followers WHERE followed_user_id = $user_id");
    $followed_info->execute();
    $row = $followed_info->fetch(PDO::FETCH_ASSOC);;
    return implode($row);
}
function count_like($conn, $post_id)
{
    $like_info = $conn->prepare("SELECT COUNT(post_id) FROM likes WHERE post_id = $post_id");
    $like_info->execute();
    $row = $like_info->fetch(PDO::FETCH_ASSOC);;
    return implode($row);
}
function count_comment($conn, $post_id)
{
    $comment_info = $conn->prepare("SELECT COUNT(post_id) FROM comments WHERE post_id = $post_id");
    $comment_info->execute();
    $row = $comment_info->fetch(PDO::FETCH_ASSOC);;
    return implode($row);
}
//query ยังไม่ถูก รอแก้ใหม่
function fetch_suggest_user($conn, $user_id)
{
    $query = "SELECT u.user_id, u.username, u.profile_pic, f.followed_user_id
    FROM users AS u LEFT OUTER JOIN followers AS f
    ON u.user_id = f.followed_user_id
    WHERE role='user' AND user_id != $user_id AND f.followed_user_id IS NULL  LIMIT 7;";
    $users = $conn->prepare($query);
    $users->execute();
    $row_users = $users->fetchAll();
    return $row_users;
}
function fetch_posts_profile($conn, $user_id)
{
    $posts_info  = $conn->prepare("SELECT * FROM posts INNER JOIN posts_media ON posts.post_id = posts_media.post_id 
    WHERE posts.user_id = $user_id ORDER BY create_at DESC");
    $posts_info->execute();
    $row_posts = $posts_info->fetchAll();
    return $row_posts;
}
function fetch_post($conn, $post_id)
{
    $post_info = $conn->prepare("SELECT p.post_id, p.caption, p.create_at, 
    p.user_id, pm.media_files, u.username
    FROM posts AS p 
    NATURAL JOIN posts_media AS pm
    INNER JOIN users AS u
    ON p.user_id = u.user_id
    WHERE p.post_id = $post_id");
    $post_info->execute();
    $row = $post_info->fetch(PDO::FETCH_ASSOC);
    return $row;
}
function fetch_comment($conn, $post_id)
{
    $comments_info  = $conn->prepare("SELECT c.comment,c.create_at,u.username 
    FROM comments AS c,users AS u WHERE c.user_id = u.user_id AND post_id = $post_id");
    $comments_info->execute();
    $row_comments = $comments_info->fetchAll();
    return $row_comments;
}
function fetch_notification($conn, $user_id)
{
    $notification_info = $conn->prepare("SELECT * FROM notifications AS n 
    WHERE n.user_id = $user_id ORDER BY n.notification_id DESC, n.read_notification ASC LIMIT 10");
    $notification_info->execute();
    $row_notifications = $notification_info->fetchAll();
    return $row_notifications;
}
function make_like_button($conn, $user_id, $post_id)
{
    $query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id";
    $check = $conn->prepare($query);
    $check->execute();
    $totalRow = $check->rowCount();
    $output = '';
    //แก้ icon ปุ่ม
    if ($totalRow == 1) {
        $output = "<button class='like_btn' type='button' name='unlike' data-action='unlike' data-post=$post_id id='btn_like'>unlike
        </button>";
    } else {
        $output = "<button class='like_btn' type='button' name='like' data-action='like' data-post=$post_id id='btn_like'>like</button>";
    }
    return $output;
}
function make_follow_button($conn, $sender_id, $receiver_id)
{
    $query = "SELECT * FROM followers WHERE following_user_id = $receiver_id AND followed_user_id = $sender_id";
    $check = $conn->prepare($query);
    $check->execute();
    $totalRow = $check->rowCount();
    $output = '';
    if ($totalRow == 1) {
        $output = "<button type='button' name='unfollow' data-action='unfollow' data-sender='$receiver_id' id='btn_follow'>Following</button>";
    } else {
        $output = "<button type='button' name='follow' data-action='follow' data-sender='$receiver_id' id='btn_follow'>Follow</button>";
    }
    return $output;
}
function fetch_posts_following($conn, $user_id)
{
    $query = "
        SELECT DISTINCT p.post_id, p.caption, p.create_at, p.user_id,
        u.username, u.profile_name ,u.profile_pic, 
        pm.media_files
        FROM posts AS p INNER JOIN users AS u
        ON p.user_id = u.user_id
        LEFT OUTER JOIN followers AS flw
        ON flw.following_user_id = p.user_id
        LEFT OUTER JOIN posts_media AS pm
        ON pm.post_id = p.post_id
        WHERE flw.followed_user_id = $user_id OR p.user_id = $user_id
        ORDER BY p.post_id DESC;
        ";
    $posts_info = $conn->prepare($query);
    $posts_info->execute();
    $row_posts = $posts_info->fetchAll();
    return $row_posts;
}
function get_date_post($post_date)
{
    $date = strtotime($post_date);
    $format =  date("F j, Y, g:i a", $date);
    return $format;
}
function count_users($conn)
{
    $query = "SELECT COUNT(*)
    FROM users AS u
    WHERE u.role != 'admin'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return implode($row);
}
function count_posts($conn)
{
    $query = "SELECT COUNT(*)
    FROM posts AS p";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return implode($row);
}
