<?php
function generateStylesheetLinks($styles)
{
  if (is_array($styles)) {
    foreach ($styles as $style) {
      echo "<link rel='stylesheet' href='{$style}'>";
    }
  } else {
    echo "<link rel='stylesheet' href='{$styles}'>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="/css/header.css">
  <link rel="stylesheet" href="/css/styles.css">
  <?php generateStylesheetLinks($styles); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php echo $scripts ?? null ?>
  <script type="module" src="/js/header.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <title>ADE Bank | <?php echo $pageTitle; ?></title>
</head>

<body>
  <header>
    <a href="/" class="logo">ADE</a>
    <nav class="nav-menu">
      <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/cuenta_ahorros">Cuenta de ahorros</a></li>
        <li id="user-dropdown">
          <div class="dropdown">
            <div class="btn-container">
              <button class="dropdown-btn" id="dropdownBtn">
                <image-abbr img="" text="<?= $user['Name'] ?>" background="<?= $user['Avatar'] ?>" color="#333"
                  width="32px"></image-abbr>
                <span class="profile-info-name"></span> <i class="arrow down"></i>
              </button>
              <div class="dropdown-content">
                <a href="/user/username" id="profile_view" class="header-nav-link">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="18px"
                    preserveAspectRatio="xMidYMid meet">
                    <path
                      d="M528 160V416c0 8.8-7.2 16-16 16H320c0-44.2-35.8-80-80-80H176c-44.2 0-80 35.8-80 80H64c-8.8 0-16-7.2-16-16V160H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM272 256a64 64 0 1 0 -128 0 64 64 0 1 0 128 0zm104-48c-13.3 0-24 10.7-24 24s10.7 24 24 24h80c13.3 0 24-10.7 24-24s-10.7-24-24-24H376zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24h80c13.3 0 24-10.7 24-24s-10.7-24-24-24H376z" />
                  </svg>
                  Perfil
                </a>
                <a href="/my_profile" id="profile_editable" class="header-nav-link">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="18px"
                    preserveAspectRatio="xMidYMid meet">
                    <path
                      d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z" />
                  </svg>
                  Editar perfil
                </a>
                <a href="/logout" class="header-nav-link">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18px"
                    preserveAspectRatio="xMidYMid meet">
                    <path
                      d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z" />
                  </svg>
                  Cerrar sesión
                </a>
                <span class="header-nav-arrow"></span>
              </div>
            </div>
        </li>

      </ul>
    </nav>
    <div class="burger-menu">
      <div class="burger-line"></div>
      <div class="burger-line"></div>
      <div class="burger-line"></div>
    </div>

  </header>
  <section class="banner">
    <div class="container">
      <h1 class="banner-title">
        <?= $bannerTitle ?>
      </h1>
    </div>
  </section>