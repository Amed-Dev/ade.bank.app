<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/login.css">
  <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
  <title>Techs | login</title>
</head>

<body>
  <main id="login-container">
    <div class="contenedor__todo">
      <div class="caja__trasera">
        <div class="caja__trasera-register">
          <h3>¿Aún no tienes una cuenta?</h3>
          <p>registrate para que puedas iniciar sesión</p>
          <button id="btn__registrarse">Registrarse</button>
        </div>
      </div>
      <!-- Formulario de login y registro -->
      <div class="contenedor__login-register">
        <!-- login -->
        <form action="" method="POST" Id="login-form" class="formulario__login text-center">
          <h2>Iniciar Sesión</h2>
          <div class="input-group ">
            <span class="input-group-addon"><i class="fa-solid fa-at"></i></span>
            <input type="email" name="username" class="form-control" id="email" placeholder="Correo Electronico"
              required />
          </div>
          <div class="input-group ">
            <span class="input-group-addon">
              <i class="fa-solid fa-lock"></i>
            </span>
            <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required />
          </div>
          <button type="submit" id="btn-login">Entrar</button>
          <div id="message"></div>
        </form>
      </div>
    </div>
  </main>
  <script type="module" src="/js/login.js"></script>
</body>

</html>