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
    $user_id = $_SESSION['user_login'];
    $fetchUser = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
    $rowUser = $fetchUser->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="32px" href="/assets/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์</title>
    <link rel="icon" type="image/png" sizes="32px" href="../assets/favicon.ico">
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/sidebar.css">
    <link rel="stylesheet" href="/styles/edit_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="main-wrap">
        <div class="main-lt">
            <?php include("./component/sidebar.php"); ?>
        </div>
        <div class="main-rt">
            <div class="main-rt_inside_wrap container">
                <div class="edit_profile">
                    <div class="edit_profile_tools">
                        <nav>
                            <li class="active">
                                <a href="/acounts/edit">แก้ไขโปรไฟล์</a>
                            </li>
                            <li>
                                <a href="/acounts/password/change">เปลี่ยนรหัสผ่าน</a>
                            </li>
                        </nav>
                    </div>
                    <div class="edit_profile_mainscreen">
                        <?php if (isset($_SESSION['warning'])) { ?>
                            <div class="message warning">
                                <?php echo $_SESSION['warning'];
                                unset($_SESSION['warning']) ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($_SESSION['success'])) { ?>
                            <div class="message update">
                                <?php echo $_SESSION['success'];
                                unset($_SESSION['success']) ?>
                            </div>
                        <?php } ?>
                        <form action="/editprofile_db" method="post" enctype="multipart/form-data">
                            <div class="row ml-1">
                                <?php if (isset($rowUser['profile_pic'])) { ?>
                                    <div class="avatar-md mr-05" style="background: url(../uploads/avatar/<?php echo $rowUser['profile_pic'] ?>);"></div>
                                <?php } else {  ?>
                                    <div class="avatar-md mr-05" style="background: blue;">
                                        <p><?php echo substr($rowUser['username'], 0, 1) ?></p>
                                    </div>
                                <?php } ?>
                                <div class="px-05">
                                    <p><?php echo $rowUser['username'] ?></p>
                                    <!-- เปลี่ยนเป็น change to upload -->
                                    <button class="ch_pic_pf" type="button">
                                        เปลี่ยนรูปโปรไฟล์
                                        <input type="file" name="profile_pic" id="profile_pic" accept="image/*">
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <p>ชื่อผู้ใช้งาน</p>
                                <div class="textbox">
                                    <input type="text" name="username" id="username" placeholder="username" value="<?php echo $rowUser['username'] ?>" require>
                                </div>
                            </div>
                            <div class="row">
                                <p>ชื่อ</p>
                                <div class="textbox">
                                    <input type="text" name="profile_name" id="profile_name" placeholder="profile name" value="<?php echo $rowUser['profile_name'] ?>" require>
                                </div>
                            </div>
                            <div class="row flex_start">
                                <p>รายละเอียด</p>
                                <div class="textbox">
                                    <textarea name="bio" id="bio" placeholder="bio" maxlength="150"><?php echo $rowUser['bio'] ?></textarea>
                                    <p class="f-12 gray bio_length">0/150</p>
                                </div>
                            </div>
                            <div class="row">
                                <p>อีเมล</p>
                                <div class="textbox">
                                    <input type="email" name="email" id="email" placeholder="email" value="<?php echo $rowUser['email'] ?>" require>
                                </div>
                            </div>
                            <div class="row">
                                <p></p>
                                <button type="submit" name="editprofile">ส่ง</button>
                                <button type="button" class="del_btn">ลบบัญชี</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include(__DIR__."/delete_modal.php"); ?>
    <script type="text/javascript" src="./script/edit_profile.js"></script>

</body>

</html>