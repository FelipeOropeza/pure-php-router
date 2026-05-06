<?php

namespace App\Core;

use App\Core\Database;
use Exception;
use PDOException;

abstract class Model
{
    protected string $table;
    protected array $atributos;
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    /**
     * Insere um novo registro no banco de dados baseado nos atributos da Model.
     *
     * @param array $data Dados associativos a serem inseridos (ex: ['nome' => 'Felipe', 'email' => '...']).
     * 
     * @return string Retorna 'Ok' em caso de sucesso absoluto na inserção.
     * 
     * @throws PDOException Se houver uma falha no banco de dados (ex: email já cadastrado).
     * @throws Exception Se a quantidade de itens no array $data não bater com os atributos permitidos.
     */
    public function insert(array $data): string
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
