<?php

namespace App\Core;

class Route
{
    private static array $routes = [];
    private static string $baseView = __DIR__ . '/../view';

    public static function add(string $metodo, string $name)
    {
        self::$routes[$metodo][$name] = true;
    }

    public static function view(string $name)
    {
        $file = self::$baseView . '/' . $name . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            die("Erro: A view '{$name}' não foi encontrada em " . self::$baseView);
        }
    }

    public static function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $path => $value) {
                if ($path === $uri) {
                    $viewName = trim($path, '/');
                    self::view($viewName ?: 'index');
                    return;
                }
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 - Página não encontrada";
    }
}
