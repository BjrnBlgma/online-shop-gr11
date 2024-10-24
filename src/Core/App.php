<?php
namespace Core;

use http\Client\Request;

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

                $class = new $controllerClassName();

                $request = new Request($requestUri, $requestMethod, $_POST);

                return $class->$method($request);
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once "./../View/404.php";
        }
    }


    public function createRoute($route, $method, $className, $methodName)
    {
        $this->routes[$route][$method] = [
            'class' => $className,
            'method' => $methodName
        ];
    }

}