<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class User
{
  private $db;
  private $id;
  private $username;
  private $name;
  private $email;
  private $password;
  private $avatar;
  public function __construct($id = null, $username = null, $name = null, $email = null, $password = null, $avatar = null)
  {
    $this->id = $id;
    $this->username = $username;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->avatar = $avatar;
    $this->db = new Database();
  }

  // getters son métodos de acceso
  public function getId()
  {
    return $this->id;
  }
  public function getUsername()
  {
    return $this->username;
  }
  public function getFullName()
  {
    return $this->name;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getPassword()
  {
    return $this->password;
  }

  public function getAvatar()
  {
    return $this->avatar;
  }
  // setters son los métodos de modificación
  public function setId($newId)
  {
    $this->id = $newId;
  }

  public function setUsername($newUsername)
  {
    $this->username = $newUsername;
  }

  public function setFullName($newName)
  {
    $this->name = $newName;
  }

  public function setEmail($newEmail)
  {
    $this->email = $newEmail;
  }

  public function setPassword($newPassword)
  {
    $this->password = $newPassword;
  }

  public function setAvatar($newAvatar)
  {
    $this->avatar = $newAvatar;
  }
  public static function getUserByEmail($email)
  {
    $db = new Database();
    $sql = "SELECT * FROM users WHERE Email = :email";
    $stmt = $db->query($sql, [':email' => $email]);

    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($response) {
      return new User(
        $response['Id'],
        $response['Username'],
        $response['Name'] . " " . $response['Last_name'],
        $response['Email'],
        $response['Password'],
        $response['Avatar']
      );
    } else {
      return null;
    }
  }

  public static function getUserByUsername($username)
  {
    $db = new Database();
    $sql = "SELECT * FROM users WHERE Username = :username";
    $stmt = $db->query($sql, [':username' => $username]);

    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($response) {
      return new User(
        $response['Id'],
        $response['Username'],
        $response['Name'] . " " . $response['Last_name'],
        $response['Email'],
        $response['Password'],
        $response['Avatar']
      );
    } else {
      return null;
    }
  }

  public function createUser($name, $last_name, $username, $email, $password, $avatar)
  {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (Name, Last_name, Username, Email, Password, Avatar ) VALUES (:Name, :Last_name, :Username, :Email, :Password, :Avatar)";
    $stmt = $this->db->query($sql, [
      ':Name' => $name,
      ':Last_name' => $last_name,
      ':Username' => $username,
      ':Email' => $email,
      ':Password' => $hashedPassword,
      ':Avatar' => $avatar,
    ]);
  }

  public function getUser()
  {
    if (isset($_SESSION['user'])) {
      $userId = $_SESSION['user']['Id'];
      $stmt = $this->db->query("SELECT Username, Name, Last_name, Email FROM users WHERE Id = :id", [':id' => $userId]);
      $user = $stmt->fetch();
      $this->sendResponse(['user' => $user]);
    } else {
      $this->sendResponse(['error' => 'User not authenticated'], 401);
    }
  }
  public function updateUser()
  {
    if (isset($_SESSION['user'])) {
      $userId = $_SESSION['user']['Id'];
      $username = $_POST['username'];
      $name = $_POST['name'];
      $last_name = $_POST['last_name'];
      $email = $_POST['email'];

      $sql = "UPDATE users SET Name = :name, Last_name =:last_name, Email = :email WHERE Id = :id";
      $params = [
        ':name' => $name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':id' => $userId
      ];

      $stmt = $this->db->query($sql, $params);

      if ($stmt) {
        $user = User::getUserByUsername($username);

        $_SESSION['user'] = [
          'Id' => $_SESSION['user']['Id'],
          'Username' => $user->getUsername(),
          'Name' => $user->getFullName(),
          'Email' => $user->getEmail(),
          'Password' => $_SESSION['user']['Password'],
          'Avatar' => $user->getAvatar(),
        ];
      }

      $this->sendResponse(['status' => 'success', 'message' => 'Perfil actualizado exitosamente.', 'user' => $_SESSION['user']['Name']]);
    } else {
      $this->sendResponse(['status' => 'error', 'message' => 'User not authenticated'], 401);
    }
  }


  public function updateUserPassword()
  {
    if (isset($_SESSION['user'])) {
      $userId = $_SESSION['user']['Id'];
      $password = $_POST['new_password'];

      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

      $sql = "UPDATE users SET Password = :password WHERE Id = :id";
      $params = [
        ':password' => $hashedPassword,
        ':id' => $userId
      ];

      $stmt = $this->db->query($sql, $params);
      if ($stmt) {
        $user = User::getUserByUsername($_SESSION['user']['Username']);
        $_SESSION['user'] = [
          'Id' => $_SESSION['user']['Id'],
          'Username' => $user->getUsername(),
          'Name' => $user->getFullName(),
          'Email' => $user->getEmail(),
          'Password' => $user->getPassword(),
          'Avatar' => $user->getAvatar(),
        ];
      }

      $this->sendResponse(['status' => 'success', 'message' => 'La contraseña ha sido actualizada correctamente, usela la próxima vez que inicie sesión']);
    } else {
      $this->sendResponse(['status' => 'error', 'message' => 'User not authenticated'], 401);
    }
  }
  public function deleteUserAccount()
  {
    if (isset($_SESSION['user'])) {
      $userId = $_SESSION['user']['Id'];

      $this->db->query("DELETE FROM users WHERE Id = :id", [':id' => $userId]);

      session_destroy();
      $this->sendResponse(['status' => 'success', 'message' => 'Cuenta eliminada exitosamente']);
    } else {
      $this->sendResponse(['status' => 'error', 'message' => 'User not authenticated'], 401);
    }
  }

  public function getDataUser()
  {
    if (isset($_SESSION['user'])) {
      $user = [
        'Username' => $_SESSION['user']['Username'],
        'Name' => $_SESSION['user']['Name'],
        'Email' => $_SESSION['user']['Email'],
      ];
      echo json_encode(['user' => $user]);
    } else {
      echo json_encode(["error" => 'User not found']);
    }
  }
  private function sendResponse($data, $statusCode = 200)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
