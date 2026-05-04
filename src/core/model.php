<?php

namespace App\Core;


abstract class Model
{
    protected string $table;
    protected array $atributos;

    public function teste(){
       var_dump($this->table);
       var_dump($this->atributos);
    }
}
