<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/register.css">
  <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
  <title>Techs | Register</title>
</head>

<body>
  <main id="register-container">
    <div class="contenedor__todo">
      <div class="caja__trasera">
        <div class="caja__trasera-login">
          <h3>¿Ya tienes una cuenta?</h3>
          <p>Inicia sesión para entrar en la página</p>
          <button id="btn__iniciar-sesion">Iniciar Sesión</button>
        </div>
      </div>
      <!-- Formulario de login y registro -->
      <div class="contenedor__login-register">
        <!-- register -->
        <form method="POST" id="register" class="formulario__register text-center">
          <h2>Registrarse</h2>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa-solid fa-address-card"></i>
            </span>
            <input type="text" name="name" class="form-control" id="name" placeholder="Nombres" required />
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa-solid fa-address-card"></i>
            </span>
            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Apellidos" required />
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa-solid fa-at"></i>
            </span>
            <input type="text" name="username" id="usename" class="form-control" placeholder="Usuario" required />
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa-solid fa-envelope"></i>
            </span>
            <input type="email" name="email" id="email" class="form-control" placeholder="Correo Electronico"
              required />
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa-solid fa-lock"></i>
            </span>
            <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña"
              required />
          </div>
          <button type="submit">Regístrarse</button>
          <div id="message"></div>
        </form>
      </div>
    </div>
  </main>
  <script type="module" src="/js/register.js"></script>
</body>

</html>