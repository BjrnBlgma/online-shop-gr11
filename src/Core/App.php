<?php
namespace Core;

use Service\Logger\LoggerFileService;
use Service\Logger\LoggerServiceInterface;

class App
{
    private array $routes = [];
    private LoggerServiceInterface $log;
    public function __construct(LoggerServiceInterface $loggerService)
    {
        $this->log = $loggerService;
    }

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $route = $this->routes[$requestUri];

            if (isset($route[$requestMethod])) {
                $controllerClassName = $route[$requestMethod]['class'];
                $methodName = $route[$requestMethod]['method'];
                $requestClass = $route[$requestMethod]['request'];

                $class = new $controllerClassName();
                // сделать общий контроллер с конструктором??? где остальные контроллеры будут просто наследовать?


                $request = $requestClass ? new $requestClass($requestUri, $requestMethod, $_POST): null;

                try {
                    return $class->$methodName($request);
                } catch(\Throwable $exception) {
                    $this->log->error(
                        'Произошла ошибка при обработке', [
                            'message' => $exception->getMessage(),
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine()
                        ]
                    );

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
        string $requestClass = null
    )
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
}