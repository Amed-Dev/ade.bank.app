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
    if (isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];
      $stmt = $this->db->query("SELECT username, name, email FROM users WHERE id = :id", [':id' => $userId]);
      $user = $stmt->fetch();
      $this->sendResponse(['user' => $user]);
    } else {
      $this->sendResponse(['error' => 'User not authenticated'], 401);
    }
  }
  public function updateUser()
  {
    if (isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

      $sql = "UPDATE users SET name = :name, email = :email";
      $params = [
        ':name' => $name,
        ':email' => $email,
        ':id' => $userId
      ];

      if ($password) {
        $sql .= ", password = :password";
        $params[':password'] = $password;
      }

      $sql .= " WHERE id = :id";

      $this->db->query($sql, $params);

      $this->sendResponse(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
      $this->sendResponse(['error' => 'User not authenticated'], 401);
    }
  }

  public function deleteUser()
  {
    if (isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];

      $this->db->query("DELETE FROM users WHERE id = :id", [':id' => $userId]);

      session_destroy();
      $this->sendResponse(['status' => 'success', 'message' => 'Account deleted successfully']);
    } else {
      $this->sendResponse(['error' => 'User not authenticated'], 401);
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
