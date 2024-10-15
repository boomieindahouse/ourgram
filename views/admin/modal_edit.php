<div class="edit_profile_modal">
    <div class="edit_profile_modal_content">
        <?php if (isset($_SESSION['warning'])) { ?>
            <div class="message warning">
                <?php echo $_SESSION['warning'];
                unset($_SESSION['warning']) ?>
            </div>
        <?php } ?>
        <form action="/admin_db" method="post">
        <input type="hidden" name="user_id" id="user_id" >
            <div class="row">
                <p>ชื่อผู้ใช้งาน</p>
                <div class="textbox">
                    <input type="text" name="username" id="username" placeholder="username"  require>
                </div>
            </div>
            <div class="row">
                <p>ชื่อ</p>
                <div class="textbox">
                    <input type="text" name="profile_name" id="profile_name" placeholder="profile name"  require>
                </div>
            </div>
            <div class="row flex_start">
                <p>รายละเอียด</p>
                <div class="textbox">
                    <textarea name="bio" id="bio" placeholder="bio" maxlength="150"></textarea>
                    <p class="f-12 gray bio_length">0/150</p>
                </div>
            </div>
            <div class="row">
                <p>อีเมล</p>
                <div class="textbox">
                    <input type="email" name="email" id="email" placeholder="email" require>
                </div>
            </div>
            <div class="row">
                <p></p>
                <button name="edit_user" type="submit">Submit</button>
                <button type="button" class="cancel_btn">Close</button>
            </div>

        </form>
    </div>
</div>