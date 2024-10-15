<?php
include("connect.php");

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
    <title>Users</title>

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
                <input type="text" name="tb_search" 
                placeholder="Search:Email, Username " maxlength="100">
            </div>
        </div>
        <div class="tb_warpper">
            <table class="table" id="table_users">
                <thead>
                    <tr>
                        <th>user_id</th>
                        <th>username</th>
                        <th>email</th>
                        <th>profile_name</th>
                        <th>create_at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody class="tbody_user">

                </tbody>
            </table>
        </div>

        <div class="tb_bottom">
            <div class="pagination pagination_user">

            </div>
        </div>
    </div>
    <?php include("modal_edit.php"); ?>
    <?php include("modal_del.php"); ?>

    <script type="text/javascript" src="/script/pagination.js"></script>
</body>

</html>