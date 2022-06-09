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
                       <span class="badge bg-primary fw-normal">${user.roles[0] === 'ROLE_USER' ? 'User' : ''}</span>
                       <span class="badge bg-danger fw-normal">${user.roles[1] === 'ROLE_ADMIN' ? 'Admin' : '' }</span>
                  </div>
              </div>
           </div>
        `;
    })
}

