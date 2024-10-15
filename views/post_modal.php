<link rel="stylesheet" href="/styles/index.css">
<link rel="stylesheet" href="/styles/modal.css">

<div class="modal_create_post">
    <div class="modal_create_post_content">
        <form class="post-input" method="POST" action="/addpost_db" enctype="multipart/form-data">
            <div class="post-input_txt">
                <textarea name="post_txt" id="" cols="30" rows="10" required></textarea>
            </div>
            <div class="post-input_img">
        
            </div>
            <div class="btns" align="right">
                <button class="btn_morepic">Add a picture</button>
                <button type="submit" name="addpost">Post</button>
            </div>
        </form>

    </div>
</div>

<div class="modal_crop ">
    <div class="modal_crop_content">
        <div class="crop_content">
            <div class="top">
                <button id="close_crop_content">
                    <i class="fa fa-close"></i>
                </button>

                <h4>Create new post</h4>
                <button id="next_crop_content" class="b blue">
                    Next
                </button>
            </div>
            <div class="main">
                <!-- <div class="pic_crop">
                </div> -->
                <img src="" alt="" class="pic_crop">
                <div class="ratio">
                    <div class="ratio_box">
                        <div id="btn_1_1">1:1</div>
                        <div id="btn_16_9">16:9</div>
                    </div>
                    <div class="ratio_toggle">
                        <i class="fa fa-expand"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>