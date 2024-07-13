<?php
namespace App\Models;

use PDO;
use PDOException;

class Database
{
  private $pdo;

  public function __construct()
  {
    $this->connect();
  }

  private function connect()
  {
    $config = require "../config/db_config.php";
    $host = $config['host'];
    $dbname = $config['dbname'];
    $username = $config['username'];
    $password = $config['password'];

    try {
      $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ];
      $this->pdo = new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
      echo "Error de conexión: " . $e->getMessage();
      exit;
    }
  }

  public function query($sql, $params = [])
  {
    $stmt = $this->pdo->prepare($sql);

    if (is_array($params)) {
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
    } else {
      $stmt->bindValue(1, $params);
    }

    $stmt->execute();
    return $stmt;
  }

  public function close()
  {
    $this->pdo = null;
  }
}

