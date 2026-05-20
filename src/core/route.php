<?php

declare(strict_types=1);

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
            http_response_code(405);
            echo "Método não permitido" . "<br>Erro: " . http_response_code();
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
        http_response_code(404);
        echo "Essa rota não existe" . "<br>Erro: " . http_response_code();
    }
}
