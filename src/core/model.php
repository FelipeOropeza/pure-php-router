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

        $colunas = '';
        foreach ($this->atributos as $coluna) {
            $colunas .= $coluna . ', ';
        }
        
        $letra = strlen($colunas) - 1;

        $colunas = substr_replace($colunas, '', -1, $letra);

        var_dump($colunas);
        $values = '';
        foreach ($this->atributos as $value) {
            $values .= ":" . $value . ', ';
        }

        // $letra = strlen($values) - 1;

        // $values = substr_replace($values, '', -1, $letra);

        $sql = "INSERT INTO usuarios {$colunas} values {$values}";
        var_dump($sql);
        // $stmt = $this->conn->prepare($sql);

        foreach ($data as $valor) {
            var_dump($valor);
        }
    }
}
