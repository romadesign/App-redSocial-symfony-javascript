findAllUsers()
async function findAllUsers() {
    document.getElementById("content_user_get").innerHTML = "";
    const response = await fetch(`/getUsersAjax`);
    const data = await response.json();
    data.forEach(user => {
        document.getElementById("content_user_get").innerHTML += `
           <div class="d-flex justify-content-between  align-items-center">
              <div class="d-flex  align-items-center">
                 <img style="width: 50px" src="https://us.123rf.com/450wm/thesomeday123/thesomeday1231712/thesomeday123171200009/91087331-icono-de-perfil-de-avatar-predeterminado-para-hombre-marcador-de-posici%C3%B3n-de-foto-gris-vector-de-ilu.jpg?ver=6" alt="">
                 <div class="content_name_user">${user.name}</div>
              </div>
              <div class="d-flex justify-content-between">
                  <div class="content_badge_roles">     
                       <span class="badge bg-primary rounded-pill fw-normal">${user.roles[0] === 'ROLE_USER' ? '&nbsp;' : ''}</span>
                       <span class="badge bg-danger rounded-pill fw-normal">${user.roles[1] === 'ROLE_ADMIN' ? '&nbsp;' : '' }</span>
                  </div>
              </div>
           </div>
        `;
    })
}



async function add(e) {
    e.preventDefault()

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

const addPost = document.getElementById('addPost')
addPost.onsubmit = async (e) => {
    e.preventDefault();
    let response = await fetch('/post_add', {
        method: 'POST',

        body: new FormData(addPost)
    }).then((response) => {
        if(response.ok){
            console.log(response.headers.get('Content-Type'))
            console.log(response.statusText)
            alert("the call works ok")
            alert(response.ok)
            alert(response.text())
            addPost.reset();
            // window.location.reload()
        }
    }).then(response => response.json())
        .then(data => console.log(data)) // the data
        .catch(error => console.log(error))

    // let result = await response.json();
    // console.log(result['msg']);
};