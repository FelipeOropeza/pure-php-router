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

        $colunas = implode(", ", $this->atributos);

        $values = array_map(fn($item) => ":" . $item, $this->atributos);
        $values = implode(", ", $values);

        $sql = "INSERT INTO {$this->table} ({$colunas}) values ({$values})";
        $stmt = $this->conn->prepare($sql);

        foreach ($this->atributos as $atributo) {
            $stmt->bindValue(":" . $atributo, $data[$atributo]);
        }

        $stmt->execute();
        
        return 'Ok';
    }
}
