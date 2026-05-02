<?php

namespace App\Core;

abstract class Controller{

    protected string $baseView = __DIR__ . '/../view';

    protected function view(string $name, array $dados = [])
    {
        $file = $this->baseView . '/' . $name . '.php';
        if (file_exists($file)) {
            extract($dados);
            require $file;
        } else {
            die("Erro: A view '{$name}' não foi encontrada em " . $this->baseView);
        }
    }

    protected function redirect(string $path)
    {
        header('Location: ' . $path);
        exit;
    }
}