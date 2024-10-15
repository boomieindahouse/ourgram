const search_sidebar = document.querySelector(".search_sidebar");
const search_sidebar_dropdown = document.querySelector(
  ".search_sidebar_dropdown"
);

search_sidebar.addEventListener("input", function (e) {
  const ul_sidebar = search_sidebar_dropdown.querySelector("ul");
  const n = e.target.value.length;
  const action = e.target.dataset.action;
  const value = e.target.value;
  const formData = new FormData();
  formData.append("action", action);
  formData.append("value", value);
  if (n > 0) {
    fetch("/search_db", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        ul_sidebar.innerHTML = "";
        for (var i = 0; i < data.length; i++) {
          const a = document.createElement("a");
          a.href = `/profile/${data[i].username}`;
          a.innerHTML = `
            <li class="row py-05 mx-05" key="${data[i].user_id}">
                <div class="avatar-md mr-05"
                style="background: url(../uploads/avatar/${data[i].profile_pic})"></div>
                <p>${data[i].username}</p>
            </li>
            `;
          ul_sidebar.appendChild(a);
        }
      })
      .catch(console.error);
    search_sidebar_dropdown.style.display = "block";
  } else {
    search_sidebar_dropdown.style.display = "none";
  }
});
