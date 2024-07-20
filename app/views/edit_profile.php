<?php
$user = $_SESSION['user'];
$pageTitle = "Mi perfil";
$bannerTitle = "Mi perfil";
$styles = ['/css/edit_profile.css', "/css/modal.css"];
$scripts = '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
include '../templates/header.php';
?>
<main id="user_data">
  <h2>Datos Generales</h2>
  <div class="container_user_data">
    <form id="profileForm" method="POST">
      <image-abbr img="" text="<?= $user['Name'] ?>" background="<?= $user['Avatar'] ?>" color="#333"
        width="72px"></image-abbr>
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name">
      </div>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" disabled>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
      </div>
      <div class="form-group">
        <a class="profile-changePassword" id="btn_change_password" data-toggle="modal"
          data-target="#change_password">Cambiar contraseña</a>
      </div>


      <button type="submit" id="btn_save">Update Profile</button>
      <button type="button" id="btn_deleteAccount" class="danger" data-toggle="modal"
        data-target="#delete_account">Delete Account</button>
    </form>
  </div>
  <div id="change_password" class="modal">
    <div class="modal_dialog modal_dialog_centered">
      <div class="modal-content">
        <div class="modal_header">
          <h2>Cambiar contraseña</h2>
          <span class="btn-close">&times;</span>
        </div>
        <div class="modal_body">
          <form id="password_change_form" method="POST">
            <div class="form-group">
              <label for="new_password">New Password:</label>
              <div class="input-group">
                <input type="password" name="new_password" class="form-control" id="new_password"
                  placeholder="Ingrese su nueva Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Debe contener al menos un número y una letra mayúscula y minúscula, y al menos 8 o más caracteres"
                  required />
                <span class="input-group-addon toggle_show_password" data-toggle="input_password"
                  data-target="#new_password">
                  <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                    <path
                      d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                    </path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="passwordConfirmation">Confirm Your Password:</label>
              <div class="input-group">
                <input type="password" name="passwordConfirmation" class="form-control" id="passwordConfirmation"
                  placeholder="Confirme su Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Debe contener al menos un número y una letra mayúscula y minúscula, y al menos 8 o más caracteres"
                  required />
                <span class="input-group-addon toggle_show_password" data-toggle="input_password"
                  data-target="#passwordConfirmation">
                  <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                    <path
                      d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                    </path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="password_match_message">
              <div class="passwords-not-match error">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1rem" fill="currentColor">
                  <path
                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24l0 112c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-112c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                </svg> La contraseña no coincide
              </div>
              <div class="passwords-match success">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="1rem">
                  <path
                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                </svg>
                Todo luce bien puede continuar con el cambio de su contraseña.
              </div>
            </div>
            <div class="password-rules">
              <p class="password-rules-title">La contraseña debe seguir las siguientes reglas:</p>
              <ul class="password-rules-list">
                <li class="password-length">
                  <p>Al menos <strong>8</strong> caracteres.</p>
                </li>
                <li class="password-digit">
                  <p>Al menos un número.</p>
                </li>
                <li class="password-lower-case">
                  <p>Al menos un carácter en minúscula.</p>
                </li>
                <li class="password-upper-case">
                  <p>Al menos un carácter en mayúscula.</p>
                </li>
                <li class="password-special-character">
                  <p>Al menos un carácter especial (<strong>!@#&amp;()-[{}]:;',"?/*~$^+=&lt;&gt;._`|%</strong>).</p>
                </li>
              </ul>
            </div>
            <div class="form-group">
              <button type="submit" class="btn" id="btn_Update_password" disabled>Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div id="delete_account" class="modal">
    <div class="modal_dialog modal_dialog_centered">
      <div class="modal-content">
        <div class="modal_header">
          <h2>Eliminar cuenta</h2>
          <span class="btn-close">&times;</span>
        </div>
        <div class="modal_body">
          <p class="card-description">¿Esta seguro de querer eliminar su cuenta? Esta acción no se podrá revertir.</p>
          <div class="card-button-wrapper">
            <button class="card-button secondary" id="btn_cancel">Cancel</button>
            <button class="card-button primary" id="deleteAccountBtn">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script type="module" src="/js/header.js"></script>
<script type="module" src="/js/edit_profile.js"></script>
<script src="/js/components/avatar/image_abbr.js"></script>

</body>

</html>