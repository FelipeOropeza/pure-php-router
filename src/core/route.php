<?php

namespace App\Core;

class Route
{
    private static array $routes = [];

    public static function add(string $method, string $name, string $controller)
    {
        self::$routes[$name] = [
            'method' => $method,
            'controller' => $controller
        ];
    }

    public static function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset(self::$routes[$uri]) && self::$routes[$uri]['method'] === $method) {
            $class = explode('@', self::$routes[$uri]['controller']);
            $functionName = $class[1];

            $className = "App\\Controller\\" . $class[0];
            
            if (class_exists($className)) {
                $controller = new $className();
                $controller->$functionName();
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 - Página não encontrada";
    }
}
