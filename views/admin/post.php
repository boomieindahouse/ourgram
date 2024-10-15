<?php
include("connect.php");
include("functions.php");
$url = $_SERVER['REQUEST_URI'];
$urlArray = explode('/', $url);
$post_id = $urlArray[4];
$post =  fetch_post($conn, $post_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="32px" href="/assets/favicon.ico">
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
</head>

<body>
    <div class="container container_wrap_admin">
        <article class="posts_admin">
            <div class="post_admin_lt">
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
            </div>
            <div class="post_admin_rt">
                <div class="comments">
                <p class="timestamp">โพสต์เมื่อ <?php echo get_date_post($post['create_at']); ?></p>
                    <ul class="comments_items">
                        <li class="my_title comments_item">
                            <div class="row">
                                <a class="mr-05 b"><?php echo $post['username'] ?></a>
                                <p><?php echo $post['caption'] ?></p>
                            </div>
                            <?php $count = count_comment($conn, $post['post_id']); ?>
                            <?php if ($count == 0) { ?>
                                <p class="btn_viewcomment">No comment</p>
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
            </div>
        </article>

    </div>
    <script src="/script/carousel.js" type="text/javascript"></script>
</body>

</html>