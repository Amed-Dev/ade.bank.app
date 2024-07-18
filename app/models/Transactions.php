<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Transactions
{
    private $db;
    private $id;
    private $originAccountId;
    private $destinationAccountId;
    private $amount;
    private $type;
    private $date;
    private $destination;
    public function __construct($id = null, $originAccountId = null, $destinationAccountId = null, $amount = null, $type = null, $date = null, $destination = null)
    {
        $this->id = $id;
        $this->originAccountId = $originAccountId;
        $this->destinationAccountId = $destinationAccountId;
        $this->amount = $amount;
        $this->type = $type;
        $this->date = $date;
        $this->destination = $destination;

    }

    // getters son métodos de acceso
    public function getId()
    {
        return $this->id;
    }
    public function getoriginAccountId()
    {
        return $this->originAccountId;
    }
    public function getdestinationAccountId()
    {
        return $this->destinationAccountId;
    }
    public function getamount()
    {
        return $this->amount;
    }
    public function gettype()
    {
        return $this->type;
    }
    public function getdate()
    {
        return $this->date;
    }
    public function getdestination()
    {
        return $this->destination;
    }

    public function setAmount($newAmount)
    {
        $this->amount = $newAmount;
    }
    public function setType($newtype)
    {
        $this->type = $newtype;
    }
    public function setDate($newDate)
    {
        $this->date = $newDate;
    }
    public function setOriginAccountId($neworiginAccountId)
    {
        $this->originAccountId = $neworiginAccountId;
    }
    public function setDestinationAccountId($newdestinationAccountId)
    {
        $this->destinationAccountId = $newdestinationAccountId;
    }

    public static function insertTransaction($originAccountId, $destinationAccountId, $amount, $type, $date, $destination)
    {
        $db = new Database(); 
        try {

            $sql = "INSERT INTO transactions (OriginAccountId, DestinationAccountId, Amount, Type, Date, Destination) VALUES (:originAccountId, :destinationAccountId, :amount, :type, :date, :destination)";
            $db->query($sql, [
                ':originAccountId' => $originAccountId,
                ':destinationAccountId' => $destinationAccountId,
                ':amount' => $amount,
                ':type' => $type,
                ':date' => $date,
                ':destination' => $destination
            ]);
            return true;
        } catch (\Exception $th) {
            error_log("Error al insertar transacción: " . $th->getMessage());
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
