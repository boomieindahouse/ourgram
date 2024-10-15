<div class="edit_profile_modal">
    <div class="edit_profile_modal_content">
        <?php if (isset($_SESSION['warning'])) { ?>
            <div class="message warning">
                <?php echo $_SESSION['warning'];
                unset($_SESSION['warning']) ?>
            </div>
        <?php } ?>
        <form action="/delAccount_db" method="post">
            <p>Please confirm your password to delete an account!</p>
            <p class="f-12 red">*If you delete an account, everything is gone.</p>
            <div class="input_wrap">
                <input type="password" name="password_txt" id="password_txt" require>
            </div>
            <div class="row flex_end">
                <input type="submit" class="cf_del_btn" value="Delete" name="del" />
                <button type="button" name="del" class="cc_btn">Cancel</button>
            </div>
        </form>
    </div>
</div>