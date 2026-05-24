<?php

declare(strict_types=1);

namespace App\Core;

use Uri\Rfc3986\Uri;

class Route
{
    private static array $routes = [];

    public static function add(string $method, string $name, string $controller)
    {
        $regexValida = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9-]+)', $name);

        $pattern = '/^' . str_replace('/', '\/', $regexValida) . '$/';

        self::$routes[$name] = [
            'method' => $method,
            'controller' => $controller,
            'regex' => $pattern
        ];
    }

    public static function run()
    {
        $uri = new Uri($_SERVER['REQUEST_URI']);
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $uri->getPath();

        $routeFound = null;
        $params = [];

        foreach (self::$routes as $name => $routeData) {
            if (preg_match($routeData['regex'], $path, $matches)) {
                $routeFound = $routeData;

                array_shift($matches);
                $params = $matches;

                break;
            }
        }

        if (!$routeFound) {
            return self::notFound();
        }

        if ($routeFound['method'] !== $method) {
            http_response_code(405);
            echo "Método não permitido" . "<br>Erro: " . http_response_code();
            return;
        }

        list($controllerName, $functionName) = explode('@', $routeFound['controller']);
        $className = "App\\Controller\\" . $controllerName;

        if (class_exists($className)) {
            $controller = new $className();

            if (method_exists($controller, $functionName)) {
                if ($method === 'POST') {
                    $data = Request::post();
                } else {
                    $data = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
                }

                $controller->$functionName($data, ...$params);
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
