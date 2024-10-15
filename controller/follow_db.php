<?php
session_start();
include('connect.php');
include("functions.php");
if (isset($_POST['action'])) {
    $my_id = $_SESSION['user_login'];
    $ur_id = $_POST['sender_id'];
    $output;
    if ($_POST['action'] == 'follow') {
        $sql_ch_fl = "SELECT * FROM followers AS f WHERE f.following_user_id = $ur_id 
        AND f.followed_user_id = $my_id";
        $check_follow = $conn->prepare($sql_ch_fl);
        $check_follow->execute();
        $row_fl = $check_follow->rowCount();
        if($row_fl == 1){
            $sql = "DELETE FROM followers WHERE following_user_id=$ur_id AND followed_user_id=$my_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $notification_query = "DELETE FROM notifications AS n WHERE n.user_id = $ur_id";
            $stmt3 = $conn->prepare($notification_query);
            $stmt3->execute();
    
            $count_follow = count_following($conn, $ur_id);
            $output = $count_follow;
        }else{
            $sql = "INSERT INTO followers (`following_user_id`, `followed_user_id`)
            VALUES ($ur_id, $my_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user_query = "SELECT u.username FROM users AS u WHERE u.user_id = $my_id";
            $stmt2 = $conn->prepare($user_query);
            $stmt2->execute();
            $user = $stmt2->fetch(PDO::FETCH_ASSOC);

            $notification_query = "INSERT INTO notifications (`read_notification`, `message_notification`, `user_id`)
                VALUES ('no', '" . $user['username'] . " following you', '$ur_id');";
            $stmt3 = $conn->prepare($notification_query);
            $stmt3->execute();

            $count_follow = count_following($conn, $ur_id);
            $output = $count_follow;
        }

    } else if ($_POST['action'] == 'unfollow') {
        $sql = "DELETE FROM followers WHERE following_user_id=$ur_id AND followed_user_id=$my_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $notification_query = "DELETE FROM notifications AS n WHERE n.user_id = $ur_id";
        $stmt3 = $conn->prepare($notification_query);
        $stmt3->execute();

        $count_follow = count_following($conn, $ur_id);
        $output = $count_follow;
    }
    echo $output;
}
