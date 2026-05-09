<?php

namespace App\Core;

use App\Core\Database;
use App\Core\Query;
use PDO;
use Exception;

/**
 * @mixin Query
 */
abstract class Model
{
    protected string $table;
    protected array $atributos;

    protected PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    /**
     * Insere um novo registro no banco de dados baseado nos atributos da Model.
     *
     * @param array $data Dados associativos a serem inseridos (ex: ['nome' => 'Felipe', 'email' => '...']).
     * 
     * @return string Retorna 'Ok' em caso de sucesso absoluto na inserção.
     * 
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

    /**
     * Deleta um registro no bando da dados com base no id.
     *
     * @param int $id Id do registro que vai ser removido.
     * 
     * @return string Retorna 'Ok' em caso de sucesso da exclução.
     * 
     */
    public function delete(int $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id);

        $stmt->execute();

        return 'Ok';
    }

    /**
     * Atualizar um registro no banco de dados baseado nos atributos da Model.
     *
     * @param array $data Dados associativos a serem atualizados (Obs: precisa atualizar tudo).
     * 
     * @param int $id Indetificador do registro que vai ser alterado.
     * 
     * @return string Retorna 'Ok' em caso de sucesso absoluto na atualização.
     * 
     * @throws Exception Se a quantidade de itens no array $data não bater com os atributos permitidos.
     */
    public function update(array $data, int $id)
    {
        if (count($this->atributos) != count($data)) {
            throw new Exception("Algo deu errado");
        }

        $colunas = array_map(fn($item) => $item . " = " . ":" . $item, $this->atributos);
        $colunas = implode(", ", $colunas);

        $sql = "UPDATE {$this->table} 
        SET {$colunas} 
        WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        foreach ($this->atributos as $atributo) {
            $stmt->bindValue(":" . $atributo, $data[$atributo]);
        }

        $stmt->bindValue(":id", $id);

        $stmt->execute();

        return 'Ok';
    }

    /**
     * @param mixed $method
     * @param mixed $args
     */
    public function __call($method, $args)
    {
        $query = new Query($this->table, $this->conn);

        return $query->$method(...$args);
    }
}
