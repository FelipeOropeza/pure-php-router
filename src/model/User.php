<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{

    protected string $primaryKey = 'id';
    protected  string $table = "usuarios";
    protected  array $atributos = ['nome', 'email', 'senha'];
}
