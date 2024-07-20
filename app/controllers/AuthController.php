<?php
namespace App\Controllers;

use App\Models\Register;
use App\Models\Login;
use App\Models\User;

session_start();
class AuthController
{
  public function login()
  {
    $login = new Login();
    return $login->login();
  }

  public function register()
  {
    $register = new Register();
    return $register->register();
  }

  public function logout()
  {
    $login = new Login();
    $login->logout();
  }
  public function profile($username)
  {
    if (!isset($_SESSION['user']) || $_SESSION['user']['Username'] !== $username) {
      header('HTTP/1.0 403 Forbidden');
      echo "Forbidden";
      exit;
    }

    $user = User::getUserByUsername($username);

    if ($user) {
      require '../App/Views/profile.php';
    } else {
      echo "User not found";
    }
  }
  public function cuenta_ahorros()
  {
    if (!isset($_SESSION['user'])) {
      header('location: /login');
    } else {

      require '../App/Views/cuenta_ahorros.php';
    }
  }
  public function dashboard()
  {
    if (!isset($_SESSION['user'])) {
      header('location: /login');
    } else {
      require '../App/Views/dashboard.php';
    }
  }

  public function edit_profile()
  {
    if (!isset($_SESSION['user'])) {
      header('location: /login');
    } else {
      require '../App/Views/edit_profile.php';
    }
  }
  public function pageNotFound()
  {
    require '../App/Views/404.php';
  }
}