const btn_create_post = document.querySelector(".btn_createpost");
const modal_create_post = document.querySelector(".modal_create_post");
const modal_create_post_content = document.querySelector(
  ".modal_create_post_content"
);

const modal_crop = document.querySelector(".modal_crop");
const modal_crop_content = document.querySelector(".modal_crop_content");

btn_create_post.addEventListener("click", function (e) {
  e.preventDefault();
  modal_create_post.style.display = "block";
});

modal_create_post.addEventListener("click", function (e) {
  if (e.target == modal_create_post_content) {
    modal_create_post.style.display = "none";
  }
});

//var cropper;

// onclick post

const btn_morepic = document.querySelector(".btn_morepic");
const input_img_wrap = document.querySelector(".post-input_img");


btn_morepic.addEventListener("click", function (e) {
  e.preventDefault();
  const input_img = input_img_wrap.querySelectorAll(".image-input_wrap") || [];
  if (input_img.length <= 5) {
    const str = `
        <div class="image-input_wrap">
            <button class="btn_del_pic">
                <i class="fa fa-times"></i> 
            </button>
            <div class="image_input-inner">
                <i class="fa fa-plus"></i>
            </div>
            <input type="file" name="imgInp[]" id="imgInp" accept="image/*" required>
        </div>
    `;
    input_img_wrap.insertAdjacentHTML("beforeend", str);

    const input_img = document.querySelectorAll(".image-input_wrap") || [];
    input_img.forEach((img_wrap) => {
      const btn_del_pic = img_wrap.querySelector(".btn_del_pic");
      const imgInp = img_wrap.querySelector("#imgInp");
      if (btn_del_pic) {
        btn_del_pic.addEventListener("click", function (e) {
          e.preventDefault();
          img_wrap.remove();
        });
      }
     
      if (imgInp) {
        imgInp.onchange = (e) => {
          const [file] = imgInp.files;
          if (file) {
            const pic = modal_crop_content.querySelector(".pic_crop");
            const btn_next =
              modal_crop_content.querySelector("#next_crop_content");
            const btn_close_crop = document.querySelector(
              "#close_crop_content"
            );

            modal_crop.style.display = "block";
            pic.src = URL.createObjectURL(file);
             const cropper = new Cropper(pic, {
              aspectRatio: 1 / 1,
            });

            btn_next.addEventListener("click", function (e) {
              e.preventDefault();

              const date = new Date().toJSON().slice(0, 10);
              const time = new Date().getTime();
              const canvas = cropper.getCroppedCanvas();
              if (canvas) {
                img_wrap.style.background = `url(${canvas.toDataURL()}) no-repeat center`;
                canvas.toBlob(function (blob) {
                  const newFile = new File([blob], date + "_" + time + ".png");
                  const dataTransfer = new DataTransfer();
                  dataTransfer.items.add(newFile);
                  imgInp.files = dataTransfer.files;
                  if (imgInp.webkitEntries.length) {
                    imgInp.dataset.file = `${dataTransfer.files[0].name}`;
                  }
                });
              }
              modal_crop.style.display = "none";
              cropper.destroy();
            });

            btn_close_crop.addEventListener("click", function (e) {
              e.preventDefault();
              modal_crop.style.display = "none";
              img_wrap.style.background = "#dfeeef";
              imgInp.value = "";
              cropper.destroy();
            });
          }
        };
      }
    });
  }
});

const toggle_ratio = modal_crop_content.querySelector(".ratio_toggle");
const ratio_box = modal_crop_content.querySelector(".ratio_box");
const btn_16_9 = ratio_box.querySelector("#btn_16_9");
const btn_1_1 = ratio_box.querySelector("#btn_1_1");

toggle_ratio.addEventListener("click", function (e) {
  ratio_box.classList.toggle("post_modal_active");
});

btn_1_1.addEventListener("click", function (e) {
  e.preventDefault();
  cropper.setAspectRatio(1 / 1);
});

btn_16_9.addEventListener("click", function (e) {
  e.preventDefault();
  cropper.setAspectRatio(16 / 9);
});
