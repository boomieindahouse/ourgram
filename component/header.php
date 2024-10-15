<div class="header">
    <nav class="container navbar">
        <div class="nav-items-lt">
            <li class="nav-item">
                <a href="/">Ourgram</a>
            </li>
        </div>
        <div class="nav-items-rt">
            <?php if (isset($_SESSION['user_login'])) { ?>
                <li class="nav-item ">
                    <button class="btn_createpost">
                        create post
                    </button>
                </li>
                <li class="nav-item">
                    <button>
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <?php $nt = fetch_notification($conn, $_SESSION['user_login']); ?>
                    <button class="noti_tg">
                        <?php if (count($nt) != 0) { ?>
                            <div class="badge"><?php echo count($nt) ?></div>
                        <?php } ?>
                        <i class="fa fa-bell-o"></i>
                    </button>
                    <div class="dropdown_noti">
                        <?php if (count($nt) != 0) { ?>
                            <ul>
                                <?php foreach ($nt as $key => $n) { ?>
                                    <li key="<?php echo $key ?>" class="f-12 gray"><?php echo $n['message_notification'] ?></li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p class="f-12 gray t-c">No notification</p>
                        <?php } ?>
                    </div>
                </li>
            <?php } else { ?>
                <li class="nav-item ">
                    <a href="/signup">Sign up</a>
                </li>
                <li class="nav-item ">
                    <a href="/signin">Sign in</a>
                </li>
            <?php } ?>
        </div>
    </nav>
</div>
<?php include("./views/post_modal.php") ?>