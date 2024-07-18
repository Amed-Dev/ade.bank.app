<?php
namespace App\Models;

use App\Models\User;


class Register
{

  public function laoadRegister()
  {
    header('location: /register');
  }

  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $_POST['name'];
      $last_name = $_POST['last_name'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $avatar = $_POST['avatar'];

      $userModel = new User();
      $userModel->createUser($name, $last_name, $username, $email, $password, $avatar);

      echo json_encode(['status' => 'success', 'message' => 'Registro exitoso']);

    } else {
      require '../app/views/register.php';
    }
  }
}
