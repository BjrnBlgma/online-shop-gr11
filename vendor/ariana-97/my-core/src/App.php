<?php
namespace Core;

use Service\Logger\LoggerFileService;
use Service\Logger\LoggerServiceInterface;
use Service\Authentication\AuthServiceInterface;
use Core\Container;

class App
{
    private array $routes = [];
    private Container $container;
    private LoggerServiceInterface $log;
    public function __construct(LoggerServiceInterface $loggerService, Container $container)
    {
        $this->log = $loggerService;
        $this->container = $container;
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

                $object = $this->container->get($controllerClassName);

                $request = $requestClass ? new $requestClass($requestUri, $requestMethod, $_POST): null;

                try {
                    return $object->$methodName($request); // вот я тупая тупость...только после нескольких перепросмотров доперла, что у меня за ошибка:O
                } catch(\Throwable $exception) {
                    $this->log->error(
                        'Произошла ошибка при обработке' ,
                        [
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

    public function postRoute(
        string $route,
        string $className,
        string $methodName,
        string $requestClass = null
    )
    {
        $this->routes[$route]['POST'] = [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass
        ];
    }

    public function getRoute(
        string $route,
        string $className,
        string $methodName,
        string $requestClass = null
    )
    {
        $this->routes[$route]['GET'] = [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass
        ];
    }
}