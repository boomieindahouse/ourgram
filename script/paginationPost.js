let itemsPerPage = 7; // Number of items to display per page
let currentPage = 1; // Current page number

const pagination_post = document.querySelector(".pagination_post");
const table_posts = document.querySelector("#table_posts");
const body_post = document.querySelector(".tbody_post");

fetch("/tb_posts", {
  method: "POST",
})
  .then((res) => res.json())
  .then((data) => {
    console.log(data);
    displayList(data, body_post, itemsPerPage, currentPage);
    setupPagination(data, pagination_post, itemsPerPage);
  });

const search_box = document.querySelector(".search_box");
search_box.addEventListener("input", function (e) {
  const action = "admin_search_posts";
  const value = e.target.value;
  const formData = new FormData();
  formData.append("action", action);
  formData.append("value", value);
  fetch("/search_db", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      displayList(data, body_post, itemsPerPage, currentPage);
      setupPagination(data, pagination, itemsPerPage);
    });
});

function displayList(items, wrapper, itemsPerPage, page) {
  wrapper.innerHTML = "";
  page--;
  const start = itemsPerPage * page;
  const end = start + itemsPerPage;
  const paginatedItems = items.slice(start, end);
  for (let i = 0; i < paginatedItems.length; i++) {
    const tr = document.createElement("tr");
    const td1 = document.createElement("td");
    const td2 = document.createElement("td");
    const td3 = document.createElement("td");
    const td4 = document.createElement("td");
    const td5 = document.createElement("td");
    const td6 = document.createElement("td");
    const td7 = document.createElement("td");
    td1.innerText = paginatedItems[i].user_id;
    td2.innerText = paginatedItems[i].post_id;
    td3.innerText = paginatedItems[i].username;
    td4.innerText = paginatedItems[i].caption;
    td6.innerText = paginatedItems[i].create_at;
    const post_id = paginatedItems[i].post_id;
    const json = JSON.parse(paginatedItems[i].media_files);
    for (let i = 0; i < json.length; i++) {
      const img = document.createElement("img");
      img.src = "/uploads/posts/" + post_id + "/" + json[i];
      td5.append(img);
    }
  
    const view_btn = document.createElement("a");
    view_btn.className = "view_post view_btn";
    view_btn.innerText = "View";
    view_btn.href = "/admin/posts/post/" + post_id;

    const edit_btn = document.createElement("button");

    edit_btn.className = "edit_post edit_btn";
    edit_btn.dataset.post_id = post_id;
    edit_btn.dataset.action = "fetch_post";
    edit_btn.innerText = "Edit";

    const del_btn = document.createElement("button");

    del_btn.className = "del_post del_btn";
    del_btn.dataset.post_id = post_id;
    del_btn.dataset.action = "delete_post";
    del_btn.innerText = "Delete";

    td7.appendChild(view_btn);
    td7.appendChild(edit_btn);
    td7.appendChild(del_btn);

    tr.style.padding = 10 + "px";
    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);
    tr.appendChild(td6);
    tr.appendChild(td7);
    wrapper.appendChild(tr);
    //edit ยังไม่ทำ
    edit_btn.addEventListener("click", function (e) {
      e.preventDefault();
      const edit_profile_modal = document.querySelector(".edit_profile_modal");
      const cancel_btn = document.querySelector(".cancel_btn");
      edit_profile_modal.style.display = "block";
      const action = edit_btn.dataset.action;
      const post_id = edit_btn.dataset.post_id;
      const formData = new FormData();
      formData.append("action", action);
      formData.append("post_id", post_id);

      cancel_btn.addEventListener("click", function (e) {
        const caption = document.getElementById("caption");
        const post_id = document.getElementById("post_id");
        edit_profile_modal.style.display = "none";
        const image_input_wrap = document.querySelector(".image_input_wrap");
        image_input_wrap.innerHTML = "";
        const p = document.createElement("p");
        image_input_wrap.append(p);
        caption.value = "";
        post_id.value = "";
      });

      fetch("/admin_db", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          const caption = document.getElementById("caption");
          const post_id = document.getElementById("post_id");
          const json = JSON.parse(data.media_files);
          caption.value = data.caption;
          post_id.value = data.post_id;
          const image_input_wrap = document.querySelector(".image_input_wrap");
          for (let i = 0; i < json.length; i++) {
            const img = document.createElement("img");
            const post_id = data.post_id;
            const file = json[i];
            const dir = "/uploads/posts/" + post_id + "/" + file;
            img.src = dir;
            image_input_wrap.append(img);
          }
        })
        .catch(console.error);
    });

    del_btn.addEventListener("click", function (e) {
      e.preventDefault();
      const del_model = document.querySelector(".del_modal");
      del_model.style.display = "block";
      const cc_btn = document.querySelector(".cc_btn");
      cc_btn.addEventListener("click", function () {
        del_model.style.display = "none";
      });
      const cf_del = document.querySelector(".cf_del_btn");
      cf_del.addEventListener("click", function (e) {
        e.preventDefault();
        const action = del_btn.dataset.action;
        const post_id = del_btn.dataset.post_id;
        const formData = new FormData();
        formData.append("action", action);
        formData.append("post_id", post_id);

        fetch("/admin_db", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.text())
          .then((res) => {
            del_model.style.display = "none";
            location.reload();
          })
          .catch(console.error);
      });
    });
  }
}

function setupPagination(items, wrapper, itemsPerPage) {
  const pageCount = Math.ceil(items.length / itemsPerPage);
  for (let i = 1; i <= pageCount; i++) {
    const btn = paginationButton(i, items);
    wrapper.appendChild(btn);
  }
}

function paginationButton(page, items) {
  const button = document.createElement("button");
  button.classList.add("pagination_btn");
  button.innerText = page;

  if (currentPage == page) button.classList.add("active");

  button.addEventListener("click", function () {
    currentPage = page;
    displayList(items, body_post, itemsPerPage, currentPage);
    const currentBtn = document.querySelector(".pagination_post button.active");
    currentBtn.classList.remove("active");
    button.classList.add("active");
  });

  return button;
}
