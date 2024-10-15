const bio_txt = document.querySelector("#bio");
const bio_length = document.querySelector(".bio_length");
bio_length.innerHTML = bio_txt.value.length + "/150";
bio_txt.addEventListener("input", function (e) {
  e.preventDefault();
  l = bio_txt.value.length;
  bio_length.innerHTML = l + "/150";
});
const profile_pic = document.querySelector("#profile_pic");
profile_pic.addEventListener("input", function (e) {
  e.preventDefault();
  const file = profile_pic.files[0];
  const formData = new FormData();
  formData.append("action", "ch_profile");
  formData.append("file", file);
  fetch("/editprofile_db", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((res) => {
      const avatar_md = document.querySelector(".avatar-md");
      avatar_md.style.background = `url(../${res})`;
      console.log(res);
    })
    .catch((error) => console.log(error));
});
const del_btn = document.querySelector(".del_btn");
const cf_del_btn = document.querySelector(".cf_del_btn");
const cc_btn = document.querySelector(".cc_btn");
const edit_profile_modal = document.querySelector(".edit_profile_modal");
const edit_profile_modal_content = edit_profile_modal.querySelector(
  ".edit_profile_modal_content"
);

edit_profile_modal.addEventListener("click", function (e) {
  if (e.target == edit_profile_modal_content) {
    edit_profile_modal.style.display = "none";
  }
});

del_btn.addEventListener("click", function (e) {
  edit_profile_modal.style.display = "block";
});

cc_btn.addEventListener("click", function (ew) {
  edit_profile_modal.style.display = "none";
});

