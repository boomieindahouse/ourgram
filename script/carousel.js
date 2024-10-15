window.onload = function () {
  const carousels = document.querySelectorAll(".carousel") || [];
  carousels.forEach((carousel) => {
    //console.log(carousel);
    setupCarousel(carousel);
  });
  function setupCarousel(carousel) {
    let show_num = 0;
    const btn_next = carousel.querySelector("#btn_next");
    const btn_prev = carousel.querySelector("#btn_prev");
    const carousel_slide = carousel.querySelector(".images_group");
    const carousel_item = carousel.querySelectorAll(".image_item");
    console.log(carousel_item);
    hiddenBtn(show_num);
    btn_prev.addEventListener("click", () => {
      show_num = --show_num % carousel_item.length;
      if (show_num < 0) show_num += carousel_item.length;
      carousel_slide.setAttribute(
        "style",
        `transform: translateX(-${show_num}00%);`
      );
      hiddenBtn(show_num);
    });
    btn_next.addEventListener("click", () => {
      show_num = ++show_num % carousel_item.length;
      carousel_slide.setAttribute(
        "style",
        `transform: translateX(-${show_num}00%);`
      );
      hiddenBtn(show_num);
    });
    function hiddenBtn(show_num) {
      if (carousel_item.length == 1) {
        btn_next.style.display = "none";
        btn_prev.style.display = "none";
      } else if (show_num == 0) {
        btn_prev.style.display = "none";
        btn_next.style.display = "block";
      } else if (show_num == carousel_item.length - 1) {
        btn_next.style.display = "none";
        btn_prev.style.display = "block";
      } else {
        btn_prev.style.display = "block";
        btn_next.style.display = "block";
      }
    }
  }
};
