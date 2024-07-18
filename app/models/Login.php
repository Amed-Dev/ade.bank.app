<?php

namespace App\Models;

use App\Models\User;
use App\Models\Account;

class Login
{

  public function loadLogin()
  {
    header('location: /login');
  }

  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $user = User::getUserByEmail($username);
      if ($user) {
        if ($user && password_verify($password, $user->getPassword())) {
          $_SESSION['user'] = [
            'Id' => $user->getId(),
            'Username' => $user->getUsername(),
            'Name' => $user->getFullName(),
            'Email' => $user->getEmail(),
            'Password' => $user->getPassword(),
            'Avatar' => $user->getAvatar(),
          ];

          $account = Account::getAccountByUserId($user->getId());
          if ($account) {
            $_SESSION['account'] = [
              'Id' => $account->getId(),
              'UserId' => $account->getUserId(),
              'AccountNumber' => $account->getAccountNumber(),
              'Balance' => $account->getBalance()
            ];
          } else {
            return null;
          }
          echo json_encode(['status' => 'success', 'message' => 'Sesión Iniciada']);
        } else {
          echo json_encode(['status' => 'failed', 'message' => 'Nombre de usuario o contraseña incorrecto.']);
        }


      } else {
        echo json_encode(['status' => 'failed', 'message' => 'Usuario no registrado']);
      }

    } else {
      require '../app/views/login.php';
    }
  }

  public function logout()
  {
    session_start();
    session_unset();
    session_destroy();
    header('location: /login');
  }
}

