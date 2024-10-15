let itemsPerPage = 10; // Number of items to display per page
let currentPage = 1; // Current page number

const pagination = document.querySelector(".pagination_user");
const table_users = document.querySelector("#table_users");
const body_user = document.querySelector(".tbody_user");

fetch("/tb_users", {
  method: "POST",
})
  .then((res) => res.json())
  .then((data) => {
    // console.log(data);
    displayList(data, body_user, itemsPerPage, currentPage);
    setupPagination(data, pagination, itemsPerPage);
  });

const search_box = document.querySelector(".search_box");
search_box.addEventListener("input", function (e) {
  const action = "admin_search_users";
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
      displayList(data, body_user, itemsPerPage, currentPage);
     // setupPagination(data, pagination, itemsPerPage);
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
    td1.innerText = paginatedItems[i].user_id;
    td2.innerText = paginatedItems[i].username;
    td3.innerText = paginatedItems[i].email;
    td4.innerText = paginatedItems[i].profile_name;
    td5.innerText = paginatedItems[i].create_at;

    const edit_btn = document.createElement("button");

    edit_btn.className = "edit_user edit_btn";
    edit_btn.dataset.user_id = paginatedItems[i].user_id;
    edit_btn.dataset.action = "fetch_user";
    edit_btn.innerText = "Edit";

    const del_btn = document.createElement("button");

    del_btn.className = "del_user del_btn";
    del_btn.dataset.user_id = paginatedItems[i].user_id;
    del_btn.dataset.action = "delete_user";
    del_btn.innerText = "Delete";

    td6.appendChild(edit_btn);
    td6.appendChild(del_btn);

    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);
    tr.appendChild(td6);
    wrapper.appendChild(tr);

    edit_btn.addEventListener("click", function (e) {
      e.preventDefault();
      console.log("click");      
      const edit_profile_modal = document.querySelector(".edit_profile_modal");
      const cancel_btn = document.querySelector(".cancel_btn");
      edit_profile_modal.style.display = "block";
      const action = edit_btn.dataset.action;
      const user_id = edit_btn.dataset.user_id;
      const formData = new FormData();
      formData.append("action", action);
      formData.append("user_id", user_id);

      cancel_btn.addEventListener("click", function (e) {
        edit_profile_modal.style.display = "none";
      });

      fetch("/admin_db", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          const user_id = document.getElementById("user_id");
          const username = document.getElementById("username");
          const profile_name = document.getElementById("profile_name");
          const bio = document.getElementById("bio");
          const email = document.getElementById("email");
          user_id.value = data.user_id;
          username.value = data.username;
          profile_name.value = data.profile_name;
          bio.value = data.bio;
          email.value = data.email;
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
        const user_id = del_btn.dataset.user_id;
        const formData = new FormData();
        formData.append("action", action);
        formData.append("user_id", user_id);

        fetch("/admin_db", {
          method: "POST",
          body: formData,
        })
          .then((res) => {
            del_model.style.display = "none";
            location.reload();
            console.log(res);
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
    displayList(items, body_user, itemsPerPage, currentPage);
    const currentBtn = document.querySelector(".pagination_user button.active");
    currentBtn.classList.remove("active");
    button.classList.add("active");
  });

  return button;
}
