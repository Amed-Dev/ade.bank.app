<?php
$user = $_SESSION['user'];
$pageTitle = "Perfil de {$user['Name']}";
$bannerTitle = "Perfil de {$user['Name']}";
$styles = '/css/profile.css';
include '../templates/header.php'
  ?>

<main class="container_card_profile">
  <div class="profile-card">
    <div class="profile_header">
      <image-abbr img="" text="<?= $user['Name'] ?>" background="<?= $user['Avatar'] ?>" color="#333"
        width="72px"></image-abbr>
      <a class="profile_edit_btn" href="/my_profile">
        <img src="/images/profile/icon-profile-edit.svg" alt="Editar perfil">
      </a>
    </div>
    <div class="data">
      <h2><?= $user['Name'] ?></h2>
      <span><?= $user['Username'] ?></span>
    </div>
    <div class="row">
      <div class="info">
        <h3>Email</h3>
        <span><?= $user['Email'] ?></span>
      </div>
    </div>
  </div>
</main>
<script type="module" src="/js/header.js"></script>
<script src="/js/utils/image_abbr.js"></script>

</body>

</html>