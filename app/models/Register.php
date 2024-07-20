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
      try {
        $name = $_POST['name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $avatar = $_POST['avatar'];

        $userModel = new User();
        $existingUser = $userModel::getUserByEmail($email);

        if ($existingUser) {
          echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya ha sido registrado por otro usuario, ingrese un correo electrónico diferente.']);
          return;
        }

        $userModel->createUser($name, $last_name, $username, $email, $password, $avatar);

        $user = $userModel::getUserByUsername($username);

        $prefix = "2477";
        $remainingLength = 11;
        $remainingNumber = rand(0, str_repeat('9', $remainingLength));

        $accountNumber = $prefix . str_pad($remainingNumber, $remainingLength, '0', STR_PAD_LEFT);

        $accountModel = new Account();
        $accountModel->createAccount($user->getId(), $accountNumber, 1000.00);

        echo json_encode(['status' => 'success', 'message' => 'Registro exitoso']);
      } catch (\Exception $th) {
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
      }



    } else {
      require '../App/Views/register.php';
    }
  }
}
