const btn_follows = document.querySelectorAll("#btn_follow");
btn_follows.forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    const action = btn.dataset.action;
    const sender_id = btn.dataset.sender;
    const formData = new FormData();
    formData.append("action", action);
    formData.append("sender_id", sender_id);

    fetch("/follow_db", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((res) => {
        if (btn.innerText == "Following") {
          btn.innerHTML = "Follow";
        } else {
          btn.innerHTML = "Following";
        }
        if (
          typeof btn.parentNode.parentNode.children[1] !== "undefined" ||
          btn.parentNode.parentNode.children[1] !== undefined
        ) {
          const follow = btn.parentNode.parentNode.children[1].children[1];
          follow.innerHTML = res + " follow";
        }
      })
      .catch((error) => console.log(error));
  });
});

const btn_likes = document.querySelectorAll("#btn_like");
btn_likes.forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    const action = btn.dataset.action;
    const post_id = btn.dataset.post;
    const formData = new FormData();
    formData.append("action", action);
    formData.append("post_id", post_id);

    console.log("action: " + action);

    const like = btn.parentNode.parentNode.parentNode.children[1];
    var n = parseInt(like.innerText.slice(5, 6));
    console.log(btn.innerText);
    fetch("/like_db", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((res) => {
        if (btn.innerText == "like") {
          btn.innerHTML = "unlike";
        } else if (btn.innerText == "unlike") {
          btn.innerHTML = "like";
        }
        console.log("res: " + res);
        like.innerHTML = "Like " + res;
      })
      .catch((error) => console.log(error));
  });
});
