<?php
namespace App\Controllers;

use App\Models\Login;
use App\Models\Register;
use App\Models\User;
use App\Models\Account;

class ApiController
{
  private $login;
  private $register;
  private $user;
  private $account;
  public function __construct()
  {
    $this->login = new Login();
    $this->register = new Register();
    $this->user = new User();
    $this->account = new Account();

  }

  public function handleRequest()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
      if (strpos($contentType, 'application/json') !== false) {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
      } else {
        $data = $_POST;
      }

      $accion = $data['method'] ?? null;

      if ($accion === null) {
        $this->sendResponse(['error' => 'No method provided'], 400);
        return;
      }

      switch ($accion) {
        case 'loadLoginView':
          $this->loadLoginView();
          break;
        case 'loadRegisterView':
          $this->register->laoadRegister();
          break;
        case 'registerNewUser':
          $this->register->register();
          break;
        case 'login':
          $this->login->login();
          break;
        case 'logout':
          $this->login->logout();
          break;
        case 'getDataUser':
          $this->user->getDataUser();
          break;
        case 'getUser':
          $this->user->getUser();
          break;
        case 'updateUser':
          $this->user->updateUser();
          break;
        case 'updateUserPassword':
          $this->user->updateUserPassword();
          break;
        case 'deleteAccount':
          $this->user->deleteUserAccount();
          break;
        case 'transfermoney':
          $this->account->payOrtransfer();
          break;
        case 'payServices':
          $this->account->payOrtransfer();
          break;
        default:
          $this->sendResponse(['error' => 'Invalid method'], 400);
          break;
      }
    } else {
      $this->sendResponse(['error' => 'Invalid request method'], 405);
    }
  }

  private function loadLoginView()
  {
    ob_start();
    require '../app/views/login.php';
    $content = ob_get_clean();
    $this->sendResponse($content);
  }

  private function sendResponse($data, $statusCode = 200)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}