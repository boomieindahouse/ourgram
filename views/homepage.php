<?php
session_start();

if (!isset($_SESSION['user_login'])) {
    if (isset($_SESSION['admin_login'])) {
        header('location: /admin/dashboard');
        exit;
    }
    header('location: /signin');
    exit;
} else {
    include("connect.php");
    include("functions.php");
    $user_id = $_SESSION['user_login'];
    $fetchUser = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
    $rowUser = $fetchUser->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/homepage.css">
    <link rel="stylesheet" href="/styles/post.css">
    <link rel="stylesheet" href="/styles/header.css">
    <link rel="stylesheet" href="/styles/sidebar.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32px" href="/assets/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css" 
    integrity="sha512-C4k/QrN4udgZnXStNFS5osxdhVECWyhMsK1pnlk+LkC7yJGCqoYxW4mH3/ZXLweODyzolwdWSqmmadudSHMRLA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Ourgram</title>
</head>

<body>
    <?php include("./component/header.php"); ?>

    <div class="main-wrap">
        <div class="main-lt">
            <?php include("./component/sidebar.php"); ?>
        </div>
        <div class="main-rt">
            <div class="main-rt_inside_wrap container">
                <div class="main-rt_inside_lt">
                    <div class="posts">
                        <?php if (isset($_SESSION['error'])) { ?>
                            <div class="message error">
                                <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php } ?>
                        <?php $posts = fetch_posts_following($conn, $_SESSION['user_login']); ?>
                        <?php foreach ($posts as $post) { ?>
                            <article class="post mx-2">
                                <div class="head">
                                    <a href="/profile/<?php echo $post['username'] ?>">
                                        <div class="head_lt row">
                                            <?php if (isset($post['profile_pic'])) { ?>
                                                <div class="avatar-md mr-05" style="background: url(/uploads/avatar/<?php echo $post['profile_pic'] ?>);"></div>
                                            <?php } else {  ?>
                                                <div class="avatar-md mr-05" style="background: blue;">
                                                    <p><?php echo substr($post['username'], 0, 1) ?></p>
                                                </div>
                                            <?php } ?>
                                            <p class="name b"><?php echo $post['username'] ?></p>
                                        </div>
                                    </a>
                                    <div class="head_rt">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </div>
                                </div>
                                <div class="body carousel">
                                    <ul class="images_group">
                                        <?php $arrImg = json_decode($post["media_files"]); ?>
                                        <?php foreach ($arrImg as $key => $img) { ?>
                                            <li class="image_item" key='<?php echo $key ?>'>
                                                <div class="image" style='background-image: url(/uploads/posts/<?php echo $post['post_id'] ?>/<?php echo $img ?>)'></div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="prev"><button id="btn_prev"><i class="fa fa-chevron-circle-left"></i></button></div>
                                    <div class="next"><button id="btn_next"><i class="fa fa-chevron-circle-right"></i></button></div>
                                </div>
                                <div class="foot">
                                    <div class="tools">
                                        <div class="tools-lt">
                                            <!-- <i class="fa fa-heart-o mr-05"></i> -->
                                            <?php echo make_like_button($conn, $_SESSION['user_login'], $post['post_id']) ?>
                                            <i class="fa fa-comment-o mr-05"></i>
                                            <i class="fa fa-share-alt "></i>
                                        </div>
                                        <div class="tools-rt">
                                            <i class="fa fa-bookmark-o"></i>
                                        </div>
                                    </div>
                                    <div class="like">Like <?php echo count_like($conn, $post['post_id']) ?></div>
                                    <div class="comments">
                                        <ul class="comments_items">
                                            <li class="my_title comments_item">
                                                <div class="row">
                                                    <a class="mr-05 b"><?php echo $post['username'] ?></a>
                                                    <p><?php echo $post['caption'] ?></p>
                                                </div>
                                                <?php $count = count_comment($conn, $post['post_id']); ?>
                                                <?php if ($count == 0) { ?>
                                                    <p class="btn_viewcomment">No comment</p>
                                                <?php } else { ?>
                                                    <button class="btn_viewcomment">View all <?php echo $count; ?> comments</button>
                                                <?php } ?>
                                            </li>
                                            <?php if ($count != 0) {
                                                $comments = fetch_comment($conn, $post['post_id']);
                                            ?>
                                                <?php foreach ($comments as $key => $comment) { ?>
                                                    <li class="comments_item" key="<?php echo $key ?>">
                                                        <div class="row">
                                                            <a class="mr-05 b"><?php echo $comment['username'] ?></a>
                                                            <p><?php echo $comment['comment'] ?></p>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <p class="timestamp"><?php echo get_date_post($post['create_at']); ?></p>
                                    <div class="input_comment">
                                        <form action="/addcomment_db" method="POST">
                                            <textarea name="comment_txt" id="comment_txt" placeholder="Type Comment" required maxlength="150"></textarea>
                                            <input type="text" name="post_id" value="<?php echo $post['post_id'] ?>" hidden>
                                            <button type="submit" name="comment_sb">Post</button>
                                        </form>

                                    </div>
                                </div>
                            </article>
                        <?php } ?>
                    </div>

                </div>
                <div class="main-rt_inside_rt">
                    <a href="/profile/<?php echo $rowUser["username"] ?>">
                        <div class="my_profile row">
                            <?php if (isset($rowUser['profile_pic'])) { ?>
                                <div class="avatar-lg" style="background: url(/uploads/avatar/<?php echo $rowUser['profile_pic'] ?>);"></div>
                            <?php } else {  ?>
                                <div class="avatar-lg" style="background: blue;">
                                    <p><?php echo substr($rowUser['username'], 0, 1) ?></p>
                                </div>
                            <?php } ?>

                            <div class="px-1">
                                <a href="/profile/<?php echo $rowUser["username"] ?>" class="b"><?php echo $rowUser['username']  ?></a>
                                <?php if (isset($rowUser['profile_name'])) { ?>
                                    <p><?php echo $rowUser['profile_name'] ?></p>
                                <?php } else {  ?>
                                    <a href="/profile/<?php echo $rowUser["username"] ?>" class="blue-sub f-12">Edit Profile</a>
                                <?php } ?>
                            </div>
                        </div>
                    </a>

                    <div class="row space_between py-2">
                        <p class="gray b">Suggest people</p>
                        <a href="" class="b">See more</a>
                    </div>
                    <ul>
                        <?php $rowUsers = fetch_suggest_user($conn, $user_id); ?>
                        <?php foreach ($rowUsers as $user) { ?>
                            <li class="py-1">
                                <div class="row space_between">
                                    <a href="/profile/<?php echo $user["username"] ?>">
                                        <div class="row">
                                            <?php if (isset($user['profile_pic'])) { ?>
                                                <div class="avatar-md" style="background: url(/uploads/avatar/<?php echo $user['profile_pic'] ?>);"></div>
                                            <?php } else {  ?>
                                                <div class="avatar-md" style="background: blue;">
                                                    <p><?php echo substr($user['username'], 0, 1) ?></p>
                                                </div>
                                            <?php } ?>
                                            <p class="p-1"><?php echo $user["username"] ?></p>
                                        </div>
                                    </a>
                                    <?php echo make_follow_button($conn, $user_id, $user['user_id']) ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" 
    integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/script/carousel.js" type="text/javascript"></script>
    <script src="/script/modal.js" type="text/javascript"></script>
    <script src="/script/action_button.js" type="text/javascript"></script>
    <script src="/script/header.js" type="text/javascript"></script>
    <script src="/script/search.js" type="text/javascript"></script>
</body>

</html>