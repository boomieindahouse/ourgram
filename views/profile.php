<?php
session_start();
if (!isset($_SESSION['user_login'])) {
    if(isset($_SESSION['admin_login'])){
        header('location: /admin/dashboard');
        exit;
    }
    header('location: /signin');
    exit;
} else {
    include("connect.php");
    include("functions.php");
    $my_user_id = $_SESSION['user_login'];
    $param = substr($_SERVER['REQUEST_URI'], 9);
    //fetch user
    $user_info = $conn->query("SELECT * FROM users WHERE username = '$param'");
    $row_user = $user_info->fetch(PDO::FETCH_ASSOC);
    //fetch post
    $row_posts = fetch_posts_profile($conn, $row_user['user_id']);
    //fetch follower
    $row_following = count_following($conn, $row_user['user_id']);
    $row_followed = count_followed($conn, $row_user['user_id']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/profile.css">
    <link rel="stylesheet" href="/styles/header.css">
    <link rel="stylesheet" href="/styles/sidebar.css">
    <link rel="icon" type="image/png" sizes="32px" href="/assets/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css" 
    integrity="sha512-C4k/QrN4udgZnXStNFS5osxdhVECWyhMsK1pnlk+LkC7yJGCqoYxW4mH3/ZXLweODyzolwdWSqmmadudSHMRLA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32px" href="../assets/favicon.ico">
    <title><?php echo  $row_user["profile_name"] ?> (@<?php echo  $row_user["profile_name"] ?>)</title>
</head>

<body>
    <?php include("./component/header.php"); ?>
    <div class="main-wrap">
        <div class="main-lt">
            <?php include("./component/sidebar.php"); ?>
        </div>
        <div class="main-rt">
            <div class="main-rt_inside_wrap container">
                <div class="top_profile">
                    <div class="profile_img" align="center">
                        <?php if (isset($row_user['profile_pic'])) { ?>
                            <div class="img" style="background: url(/uploads/avatar/<?php echo $row_user['profile_pic'] ?>);"></div>
                        <?php } else {  ?>
                            <div class="img" style="background: blue;">
                                <p><?php echo substr($row_user['username'], 0, 1) ?></p>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="profile_txt">
                        <div class="row mb-2">
                            <p class="profile_name "><?php echo  $row_user["username"] ?></p>
                            <?php if ($_SESSION['user_login'] == $row_user['user_id']) { ?>
                                <a href="/acounts/edit" class="edit_btn">Edit Profile</a>
                            <?php } else { ?>
                                <?php echo make_follow_button($conn,  $_SESSION['user_login'], $row_user['user_id']); ?>
                            <?php } ?>
                        </div>

                        <div class="profile_desc row mb-2">
                            <div><?php echo count($row_posts) ?> Post</div>
                            <div class="px-1"><?php echo $row_following ?> follow</div>
                            <div class="px-1"><?php echo $row_followed ?> following</div>
                        </div>
                        <div class="profile_bio">
                            <p><?php echo  $row_user["profile_name"] ?></p>
                            <p><?php echo  $row_user["bio"] ?></p>
                        </div>
                    </div>
                </div>

                <div class="bottom_post">
                    <div class="line row center">
                        <div class="p-1 profile_tag_active">
                            <i class="fa fa-table"></i>
                            Post
                        </div>
                        <div class="p-1">
                            <i class="fa fa-tag"></i>
                            Tag
                        </div>
                    </div>
                    <div class="posts ">
                        <?php
                        foreach ($row_posts as $post) { ?>
                            <?php $arrImg = json_decode($post["media_files"]) ?>
                            <div class="post">
                                <div class="post_hovered">
                                    <div class="row white b f-20">
                                        <i class="fa fa-heart"></i>
                                        <p class="p-1"><?php echo count_like($conn, $post["post_id"]) ?></p>
                                    </div>
                                    <div class="row white b f-20">
                                        <i class="fa fa-comment"></i>
                                        <p class="p-1"><?php echo count_comment($conn, $post["post_id"]) ?></p>
                                    </div>
                                </div>
                                <div class="post_bg" style="background-image: url('/uploads/posts/<?php echo $post['post_id'] ?>/<?php echo $arrImg[0] ?>');"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/script/modal.js" type="text/javascript"></script>
    <script src="/script/action_button.js" type="text/javascript"></script>
    <script src="/script/header.js" type="text/javascript"></script>
</body>

</html>