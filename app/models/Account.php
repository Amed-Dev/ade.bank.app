<?php
namespace App\Models;

use App\Models\Database;
use App\Models\Transactions;
use PDO;

class Account
{
  private $db;
  private $id;
  private $userId;
  private $accountNumber;
  private $balance;
  public function __construct($id = null, $userId = null, $accountNumber = null, $balance = null)
  {
    $this->id = $id;
    $this->userId = $userId;
    $this->accountNumber = $accountNumber;
    $this->balance = $balance;
    $this->db = new Database();
  }

  // getters son métodos de acceso
  public function getId()
  {
    return $this->id;
  }
  public function getAccountNumber()
  {
    return $this->accountNumber;
  }
  public function getBalance()
  {
    return $this->balance;
  }
  public function getUserId()
  {
    return $this->userId;
  }

  // setters son los métodos de modificación
  public function setBalance($newBalance)
  {
    $this->name = $newBalance;
  }
  public static function getAccountByUserId($userId)
  {
    $db = new Database();
    $sql = "SELECT * FROM account WHERE UserId = :userId";
    $stmt = $db->query($sql, [':userId' => $userId]);

    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($response) {
      return new Account(
        $response['Id'],
        $response['UserId'],
        $response['AccountNumber'],
        $response['Balance'],
      );
    } else {
      return null;
    }
  }
  public function getAccountByAccountNumber($accountNumber)
  {
      $db = new Database();
      $sql = "SELECT * FROM account WHERE AccountNumber = :AccountNumber";
      $stmt = $db->query($sql, [':AccountNumber' => $accountNumber]);
      $response = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($response) {
          return new Account(
              $response['Id'],
              $response['UserId'],
              $response['AccountNumber'],
              $response['Balance']
          );
      } else {
          return null; // Devuelve null si no se encuentra la cuenta
      }
  }
  public function createAccount($userId, $accountNumber, $balance)
  {
    $sql = "INSERT INTO account (UserId, AccountNumber, Balance ) VALUES (:UserId, :AccountNumber, :Balance)";
    $stmt = $this->db->query($sql, [
      ':UserId' => $userId,
      ':AccountNumber' => $accountNumber,
      ':Balance' => $balance
    ]);
  }



  public function payOrtransfer()
  {
      try {
          $response = ['status' => 'failed', 'message' => ''];
  
          if (isset($_SESSION['user']['Id'])) {
              $userId = $_SESSION['user']['Id'];
            
              if (isset($_POST['accountnumber']) && isset($_POST['amount']) && isset($_POST['transaction']) && isset($_POST['destination'])) {
                  $accountNumber = $_POST['accountnumber'];
                  $amount = $_POST['amount'];
                  $typeTransaction = $_POST['transaction'];
                  $destination = $_POST['destination'];
                  // Obtener cuenta de destino
                  $userDestination = $this->getAccountByAccountNumber($accountNumber);
  
                  if ($userDestination) {
                      // Realizar el pago a la cuenta de destino
                      $pay = $this->payDestinationAccount($userDestination, $amount);
  
                      if ($pay) {
                          // Obtener cuenta de origen
                          $userOrigin = $this->getAccountByUserId($userId);
  
                          if ($userOrigin) {
                              // Realizar el débito en la cuenta de origen
                              $debit = $this->debitOriginAccount($userOrigin, $amount);
  
                              if ($debit) {
                                  // Registrar la transacción
                                  $transaction = Transactions::insertTransaction(
                                      $userOrigin->getId(),
                                      $userDestination->getId(),
                                      $amount,
                                      $typeTransaction == "transfer" ? "transfer" : "pay services",
                                      date('Y-m-d H:i:s'),
                                      $destination
                                  );
  
                                  if ($transaction) {
                                    $account = $this->getAccountByUserId($userId);
                                      $_SESSION['account'] = [
                                        'Id' => $account->getId(),
                                        'UserId' => $account->getUserId(),
                                        'AccountNumber' => $account->getAccountNumber(),
                                        'Balance' => $account->getBalance()
                                      ]; 
                                      // Transacción exitosa
                                      $response['status'] = 'success';
                                      $response['message'] = $typeTransaction == "transfer" ? 'Transacción exitosa.': "Operación exitosa.";
                                  } else {
                                      // Error en el registro de la transacción
                                      $response['message'] = 'Transacción fallida. Registro de transacción fallido.';
                                  }
                              } else {
                                  // Error en el débito de la cuenta de origen
                                  $response['message'] = 'Transacción fallida. Débito fallido.';
                              }
                          } else {
                              // Cuenta de origen no encontrada
                              $response['message'] = 'Transacción fallida. Cuenta de origen no encontrada.';
                          }
                      } else {
                          // Error en el pago a la cuenta de destino
                          $response['message'] = 'Transacción fallida. Envío fallido.';
                      }
                  } else {
                      // Cuenta de destino no encontrada
                      $response['message'] = 'Transacción fallida. Cuenta de destino no encontrada.';
                  }
              } else {
                  // Número de cuenta o monto no proporcionado
                  $response['message'] = 'Transacción fallida. Número de cuenta o monto no proporcionado.' . print_r($_POST,true);
              }
          } else {
              // Usuario no encontrado en la sesión
              $response['message'] = 'Transacción fallida. Usuario no encontrado en la sesión.';
          }
  
          echo json_encode($response);
  
      } catch (\Exception $th) {
          echo json_encode(['status' => 'failed', 'message' => 'Transacción fallida. Error: ' . $th->getMessage()]);
      }
  }
  
  


  public function debitOriginAccount($user, $amount)
  {
      try {
          $newBalance = $user->getBalance() - $amount;
          $sql = "UPDATE account SET Balance = :Balance WHERE AccountNumber = :AccountNumber";
          $this->db->query($sql, [
              ':AccountNumber' => $user->getAccountNumber(),
              ':Balance' => $newBalance
          ]);
          return true;
      } catch (\Exception $th) {
          return false;
      }
  }

  public function payDestinationAccount($user, $amount)
  {
      try {
          $newBalance = $user->getBalance() + $amount;
          $sql = "UPDATE account SET Balance = :Balance WHERE AccountNumber = :AccountNumber";
          $this->db->query($sql, [
              ':AccountNumber' => $user->getAccountNumber(),
              ':Balance' => $newBalance
          ]);
          return true;
      } catch (\Exception $th) {
          return false;
      }
  }

  private function sendResponse($data, $statusCode = 200)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
