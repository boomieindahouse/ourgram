<?php
include("connect.php");
include("functions.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="32px" href="/assets/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/dashboard.css">
    <link rel="stylesheet" href="/styles/modal_del.css">
    <link rel="stylesheet" href="/styles/modal_edit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Post</title>

</head>

<body>
    <div class="dmenu">
        <nav>
            <li>
                <a href="/admin/dashboard">
                    <i class="fa fa-2x fa-home" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="/admin/users">
                    <i class="fa fa-2x fa-user" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="/admin/posts">
                    <i class="fa fa-2x fa-instagram" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="/logout">
                    <i class="fa fa-2x fa-sign-out" aria-hidden="true"></i>
                </a>
            </li>
        </nav>
    </div>
    <div class="container">
        <div class="tb_header">
            <div class="search_box">
                <input type="text" name="tb_search_post" data-action="search_post" 
                placeholder="Search:Username, Email, Caption " maxlength="100">
            </div>
        </div>
        <div class="tb_warpper">
            <table class="table" id="table_posts">
                <thead>
                    <tr>
                        <th>รหัสสมาชิก</th>
                        <th>รหัสโพสต์</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>แคปชั่น</th>
                        <th>ไฟล์</th>
                        <th>วันเวลาโพสต์</th>
                        <th>การกระทำ</th>
                    </tr>
                </thead>
                <tbody class="tbody_post">

                </tbody>
            </table>
        </div>

        <div class="tb_bottom">
            <div class="pagination pagination_post">
            </div>
        </div>
    </div>

    <?php include("modal_edit_post.php"); ?>
    <?php include("modal_del.php"); ?>
    <script src="/script/paginationPost.js" type="text/javascript"></script>

</body>

</html>