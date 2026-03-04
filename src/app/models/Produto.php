<?php

namespace CSTSI\Dbe2\app\models;

use Exception;

class Produto extends Model
{

    public function __construct()
    {
        $this->table = 'produtos';
        $this->init();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM $this->table";
        $prepStmt = $this->conn->prepare($sql);

        if ($prepStmt->execute()) {
            // var_dump($prepStmt);
            return $prepStmt->fetchAll(self::FETCH);
        } else {
            throw new Exception("Erro ao ler dados do banco!");
        }
    }
}
