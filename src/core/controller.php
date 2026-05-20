<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected string $baseView = __DIR__ . '/../view';
    protected string $layout = '';

    protected function view(string $name, array $dados = [])
    {
        $file = $this->baseView . '/' . $name . '.php';

        if (!file_exists($file)) {
            die("Erro: A view '{$name}' não foi encontrada em " . $this->baseView);
        }

        extract($dados);

        if (!empty($this->layout)) {
            $baseLayout = $this->baseView . '/' . $this->layout;

            ob_start();

            require $file;

            $conteudoDaPagina = ob_get_clean();
            require $baseLayout;
        } else {
            require $file;
        }
    }

    protected function redirect(string $path)
    {
        header('Location: ' . $path);
        exit;
    }
}
