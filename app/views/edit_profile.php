<?php
$user = $_SESSION['user'];
$pageTitle = "Mi perfil";
$bannerTitle = "Mi perfil";
$styles = '/css/edit_profile.css';
include '../templates/header.php';
?>
<main id="user_data">
  <h2>Datos Generales</h2>
  <div class="container_user_data">
    <form id="profileForm">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" disabled>
      </div>
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
      </div>
      <div class="form-group">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password">
      </div>
      <button type="submit">Update Profile</button>
    </form>
    <button id="deleteAccountBtn" class="danger">Delete Account</button>
  </div>
</main>

<script type="module" src="/js/header.js"></script>
<script type="module" src="/js/edit_profile.js"></script>
<script src="/js/utils/image_abbr.js"></script>
</body>

</html>