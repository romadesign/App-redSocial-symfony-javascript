//fetch all users
async function getAllUser() {
  const response = await fetch("/getUsersAjax");
  const users = await response.json();
  return users;
}

//fetch all followed users
async function getAllUsersFollowed() {
  const response = await fetch("/getContacFollow");
  const followedUsers = await response
    .json()
    .then((result) => {
      return result;
    })
    .catch((error) => {
      console.log(error);
    });
  return followedUsers;
}

getAllUser().then(allUsers);
function allUsers(users) {
  document.getElementById("content_user_get").innerHTML = "";
  getAllUsersFollowed().then(followedUsers);

  function followedUsers(youFollow) {
    if (youFollow === undefined) {
      users.forEach((user) => {
        console.log(user.img, "asd");

        document.getElementById("content_user_get").innerHTML += `
               <div class="d-flex justify-content-between  align-items-center">
                  <div class="content_user_roles">
                      <div class="d-flex  align-items-center">
                         <img class="img_profile" src="/img/${user.img}" alt="">
                         <div class="content_name_user">${user.name}</div>
                      </div>
                      <div class="roles_circle d-flex justify-content-between">
                          <div class="content_badge_roles">     
                             <span class="badge bg-primary rounded-pill fw-normal">${
                               user.roles[0] === "ROLE_USER" ? "&nbsp;" : ""
                             }</span>
                             <span class="badge bg-danger rounded-pill fw-normal">${
                               user.roles[1] === "ROLE_ADMIN" ? "&nbsp;" : ""
                             }</span>
                          </div>
                      </div>
                  </div>
               </div>
            `;
      });
    } else {
      // Arreglo con Ids a filtrar a la lista de usuarios seguidos
      const followId = youFollow.map((user) => user.followed_user_id);
      // Sólo mostrar los usuarios que no estoy siguiendo
      const filteredUsers = users.filter((user) => !followId.includes(user.id));
      if (!filteredUsers.length < 1) {
        filteredUsers.forEach((user) => {
          document.getElementById("content_user_get").innerHTML += `
               <div class="d-flex justify-content-between  align-items-center">
                  <div class="content_user_roles">
                      <div class="d-flex  align-items-center">
                         <img class="img_profile" src="/img/${user.img}" alt="">
                         <div class="content_name_user">${user.name}</div>
                      </div>
                      <div class="roles_circle d-flex justify-content-between">
                          <div class="content_badge_roles">     
                             <span class="badge bg-primary rounded-pill fw-normal">${
                               user.roles[0] === "ROLE_USER" ? "&nbsp;" : ""
                             }</span>
                             <span class="badge bg-danger rounded-pill fw-normal">${
                               user.roles[1] === "ROLE_ADMIN" ? "&nbsp;" : ""
                             }</span>
                          </div>
                      </div>
                  </div>
                  <div class="d-flex">
                    <button type="button" class="btn btn-primary btn-sm btn-follow" onclick="follow(${
                      user.id
                    })">Seguir</button>
                  </div>
               </div>
            `;
        });
      } else {
        document.getElementById("content_user_get").innerHTML += `
            <div>Ya agregastes a todos los usuarios registrados quieres más?. XD</div>
            `;
      }
    }
  }
}

getAllUsersFollowed().then(getFollowedUsers);
function getFollowedUsers(followedUsers) {
  document.getElementById("content_user_get_followed").innerHTML = "";

  if (followedUsers == undefined) {
    document.getElementById("content_user_get_followed").innerHTML += `
            <div class="text-center">Necesitas <a class="dropdown-item" href="">Iniciar sesion</a> para ver esta información</div>
            
        `;
  } else {
    if (!followedUsers.length >= 1) {
      document.getElementById("content_user_get_followed").innerHTML += `
            <div>No sigues a ninguna persona que esperas. :D</div>
        `;
    } else {
      followedUsers.forEach((user) => {
        document.getElementById("content_user_get_followed").innerHTML += `
               <div class="d-flex justify-content-between  align-items-center">
                  <div class="content_user_roles">
                      <div class="d-flex  align-items-center">
                         <img class="img_profile" src="/img/${user.followed_img}" alt="">
                         <div class="content_name_user">${user.followed_name}</div>
                      </div>
                  </div>
                  <div class="d-flex">
                    <div class="">
                      <a class="nav-link dropdown-toggle button_stop_following" data-bs-toggle="dropdown"  role="button" aria-expanded="false">Siguiendo</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-center" >Enviar mensaje</a></li>
                        <li><a class="dropdown-item button_deletefollow text-center" 
                         onclick='unfollow(${user.id})'
                      >Dejar de seguir</a></li>
                      </ul>
                    </div>
                  </div>
               </div>
            `;
      });
    }
  }
}

async function add(e) {
  e.preventDefault();

  // var formData = new FormData();
  // var title = document.querySelector("#title");
  // var text = document.querySelector("#text");
  // var fileField = document.querySelector("input[type='file']");
  // var status = document.querySelector("#status");
  // var categoria = document.querySelector("#categoria");
  // var tag = document.querySelector("#tag");
  //
  //
  // formData.append('title', title);
  // formData.append('text', text);
  // formData.append('image', fileField.files[0]);
  // formData.append('status', status);
  // formData.append('categoria', categoria);
  // formData.append('tag', tag);
  //
  //
  // fetch('/post_add', {
  //     method: 'POST',
  //     body: formData
  // })
  //     .then(response => response.json())
  //     .catch(error => console.error('Error:', error))
  //     .then(response => console.log('Success:', response));
}

const addPost = document.getElementById("addPost");
addPost.onsubmit = async (e) => {
  e.preventDefault();
  let objects = [];
  let response = await fetch("/post_add", {
    method: "POST",
    body: new FormData(addPost),
  })
    .then((response) => {
      if (response.ok) {
        console.log(response.json());
        addPost.reset();
        window.location.reload();
      }
    })
    .catch((error) => console.log(error));

  // .then(value => value.json())
  // .then(value => {
  //     const msg = JSON.stringify(value['msg'])
  //     console.log(msg)
  //     addPost.reset();
  // })

  // let result = await response.json();
  // console.log(result['msg']);
};

async function unfollow(id) {
  fetch(`/unfollow/${id}`)
    .then((response) => response.json())
    .then((data) => console.log(data, "llegie aca"));
  getAllUser().then(allUsers);
  getAllUsersFollowed().then(getFollowedUsers);
}

async function follow(id) {
  console.log(id);
  var formData = new FormData();
  var followed = id;
  formData.append("followed", followed);
  fetch("/follow", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .catch((error) => console.error("Error:", error))
    .then((response) => console.log("Success:", response));
  getAllUser().then(allUsers);
  getAllUsersFollowed().then(getFollowedUsers);
}

$(function () {
  let ias = new InfiniteAjaxScroll(".content-post", {
    item: ".post-item",
    next: ".pagination .link-next",
    pagination: ".pagination",
    spinner: {
      element: ".spinner",
      delay: 600,
      show: function (element) {
        element.style.opacity = "1"; // default behaviour
        likeBtn();
        unlikeBtn();
      },

      hide: function (element) {
        element.style.opacity = "0"; // default behaviour
        likeBtn();
        unlikeBtn();
      },
    },
  });
  ias.on("last", function () {
    let el = document.querySelector(".no-more");
    el.style.opacity = "1";
  });
});

function likeBtn() {
  $(".like-btn")
    .unbind("click")
    .click(function () {
      $(this).addClass("d-none");
      $(this).parent().find(".unlike-btn").removeClass("d-none");
      //
      $.ajax({
        url: "/like",
        data: { publication: $(this).attr("data-btn-like") },
        type: "POST",
        success: function (data) {
          console.log(data);
        },
      });
    });
}

function unlikeBtn() {
  $(".unlike-btn")
    .unbind("click")
    .click(function () {
      $(this).addClass("d-none");
      $(this).parent().find(".like-btn").removeClass("d-none");
      //
      $.ajax({
        url: "/unlike",
        data: { publication: $(this).attr("data-btn-unlike") },
        type: "POST",
        success: function (data) {
          console.log(data);
        },
      });
    });
}
