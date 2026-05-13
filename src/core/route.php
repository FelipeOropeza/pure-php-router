<?php

namespace App\Core;

use Uri\Rfc3986\Uri;

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
        $uri = new Uri($_SERVER['REQUEST_URI']);
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $uri->getPath();

        if (!isset(self::$routes[$path])) {
            return self::notFound();
        }

        $route = self::$routes[$path];

        if ($route['method'] !== $method) {
            header("HTTP/1.0 405 Method Not Allowed");
            echo "Método não permitido";
            return;
        }

        list($controllerName, $functionName) = explode('@', $route['controller']);
        $className = "App\\Controller\\" . $controllerName;

        if (class_exists($className)) {
            $controller = new $className();

            if (method_exists($controller, $functionName)) {

                if ($method === 'POST') {
                    $data = Request::post();
                } else {
                    $data = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
                }

                $controller->$functionName($data);
                return;
            }
        }

        self::notFound();
    }

    private static function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        echo "404 - Página não encontrada";
    }
}
