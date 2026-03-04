<?php


namespace CSTSI\Dbe2\app\models;

use CSTSI\Dbe2\database\Connection;
use Exception;
use PDO;

abstract class Model
{

    protected PDO $conn;
    protected const FETCH = PDO::FETCH_ASSOC;

    protected string $table;

    protected function init()
    {
        try {
            $this->conn = Connection::getInstance();
        } catch (Exception $error) {
            error_log("ERRO NA MODEL");
            throw $error;
        }
    }

    public abstract function getAll(): array;
}
