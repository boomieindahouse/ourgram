<div class="edit_profile_modal">
    <div class="edit_profile_modal_content">
        <?php if (isset($_SESSION['warning'])) { ?>
            <div class="message warning">
                <?php echo $_SESSION['warning'];
                unset($_SESSION['warning']) ?>
            </div>
        <?php } ?>
        <form action="/admin_db" method="post">
        <input type="hidden" name="post_id" id="post_id" >
            <div class="row">
                <p>แคปชั่น</p>
                <div class="textbox">
                    <input type="text" name="caption" id="caption" placeholder="caption"  required>
                </div>
            </div>
            <div class="row image_input_wrap">
                <p></p>
            </div>
            
            <div class="row">
                <p></p>
                <button name="edit_post" type="submit">Submit</button>
                <button type="button" class="cancel_btn">Close</button>
            </div>

        </form>
    </div>
</div>