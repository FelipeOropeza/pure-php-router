<?php

namespace App\Core;

class Query
{

    protected array $query = [];
    protected string $table;
    protected \PDO $conn;

    public function __construct(string $table, \PDO $PDO)
    {
        $this->table = $table;
        $this->conn = $PDO;
    }

    /**
     * Seleciona quais campos vc quer que mostre no select.
     *
     * @param string $campo Nome do campo que vai mostrar.
     * 
     * @return $this
     */
    public function select(string $campo = "*")
    {
        $this->query['select'] = $campo;

        return $this;
    }

    /**
     * Cria uma condição no select.
     *
     * @param string $campo Nome do campo que vai receber a condição.
     * 
     * @param string $condicao Condição a ser atendida pelo campo (=, <, >, <>)
     * 
     * @param string|int $valor Valor do campo que vai ser comparado á condição.
     * 
     * @return $this
     */
    public function where(string $campo, string $condicao, string|int|null $valor = null)
    {
        if ($valor === null) {
            $valor = $condicao;
            $condicao = "=";
        }

        $this->query['where'][] = [$campo, $condicao, $valor];

        return $this;
    }

    /**
     * Limita a quantidade de registros
     *
     * @param int $valor Quantidade de registros.
     * 
     * @return $this
     */

    public function limit(int $valor)
    {
        $this->query['limit'] = $valor;

        return $this;
    }

    public function get(): array
    {
        $sql = "SELECT {$this->query['select']} FROM {$this->table}";
        $valores = [];

        if (!empty($this->query['where'])) {
            $wheres = [];

            foreach ($this->query['where'] as $i => $where) {

                $campo = $where[0];
                $condicao = $where[1];
                $valor = $where[2];

                $placeholder = ":valor_where{$i}";

                $wheres[] = "{$campo} {$condicao} {$placeholder}";

                $valores[$placeholder] = $valor;
            }

            $sql .= " WHERE " . implode(" AND ", $wheres);
        }

        if (!empty($this->query['limit'])) {
            $l = $this->query['limit'];
            $valor = $l;
            $sql .= " LIMIT {$valor}";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($valores);

        return $stmt->fetchAll(\PDO::FETCH_CLASSTYPE);
    }
}
