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
    public function select(string $campo = "")
    {
        if (empty($campo)) {
            $this->query['select'] = "*";

            return $this;
        }
        $this->query['select'] = $campo;

        return $this;
    }

    /**
     * Cria uma condição no select.
     *
     * @param string $campo Nome do campo que vai receber a condição.
     * 
     * @param string $valor Valor do campo que vai ser comparado.
     * 
     * @return $this
     */
    public function where(string $campo, string|int $condicao, string|int|null $valor = null)
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
            $w = $this->query['where'][0];
            $campo = $w[0];
            $condicao = $w[1];
            $valor = $w[2];

            $sql .= " WHERE {$campo} {$condicao} :valor_where";

            $valores[':valor_where'] = $valor;
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
