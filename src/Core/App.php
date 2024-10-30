<?php
namespace Core;

use Controller\LoginController;
use http\Client\Request;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\ProductRequest;
use Request\RegistrateRequest;
use Request\WishlistRequest;

class App
{
    private array $routes = [];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $route = $this->routes[$requestUri];

            if (isset($route[$requestMethod])) {
                $controllerClassName = $route[$requestMethod]['class'];
                $method = $route[$requestMethod]['method'];
                $requestClass = $route[$requestMethod]['request'];

                $class = new $controllerClassName();
                $request = $requestClass ? new $requestClass($requestUri, $requestMethod, $_POST): null;

                try {
                    return $class->$method($request);
                } catch(\Throwable $exception) {
                    date_default_timezone_set('Asia/Irkutsk');
                    $errors = [
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'datetime' => 'Дата: '  . date('d.m.Y H:i:s') . "\n" .  "\n"
                    ];
                    $file = './../Storage/Log/errors.txt';
                    file_put_contents($file, implode("\n", $errors), FILE_APPEND | LOCK_EX);

                    http_response_code(500);
                    require_once "./../View/500.php";
                }
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once "./../View/404.php";
        }
    }


    public function createRoute(
        string $route,
        string $method,
        string $className,
        string $methodName,
        string $requestClass = null)
    {
        $this->routes[$route][$method] = [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass
        ];
    }

    public function postRoute(string $route, string $className, string $methodName, string $requestClass = null)
    {
        $this->routes[$route]['POST'] = [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass
        ];
    }

    public function getRoute(string $route, string $className, string $methodName, string $requestClass = null)
    {
        $this->routes[$route]['GET'] = [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass
        ];
    }
}