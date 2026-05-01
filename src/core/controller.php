<?php

namespace App\Core;

abstract class Controller{

    protected string $baseView = __DIR__ . '/../view';

    protected function view(string $name)
    {
        $file = $this->baseView . '/' . $name . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            die("Erro: A view '{$name}' não foi encontrada em " . $this->baseView);
        }
    }
}