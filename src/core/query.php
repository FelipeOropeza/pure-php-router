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
    public function select($campo)
    {
        $this->query['select'] = $campo;

        return $this;
    }

    /**
     * Cria uma condição de igualdade no select.
     *
     * @param string $campo Nome do campo que vai receber a condição.
     * 
     * @param string $valor Valor do campo que vai ser comparado.
     * 
     * @return $this
     */
    public function where($campo, $valor)
    {
        $this->query['where'][] = [$campo, $valor];

        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->query['select']} FROM {$this->table}";
        $valores = [];

        if (!empty($this->query['where'])) {
            $w = $this->query['where'][0];
            $campo = $w[0];
            $valor = $w[1];

            $sql .= " WHERE {$campo} = :valor_where";

            $valores[':valor_where'] = $valor;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($valores);

        return $stmt->fetchAll(\PDO::FETCH_CLASSTYPE);
    }
}
