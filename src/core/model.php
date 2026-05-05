<?php

namespace App\Core;

use App\Core\Database;
use Exception;

abstract class Model
{
    protected string $table;
    protected array $atributos;
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function insert(array $data)
    {
        if (count($this->atributos) != count($data)) {
             throw new Exception("Algo deu errado");
        }
    }
}
