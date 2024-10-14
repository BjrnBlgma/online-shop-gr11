<?php
require_once "./../Controller/UserController.php";
require_once "./../Controller/CartController.php";
require_once "./../Controller/ProductController.php";
require_once "./../Controller/LoginController.php";
require_once './../Controller/OrderController.php';


class App
{
    private array $routes = [
        '/login' =>
            [
            'GET' =>
                [
                'class' => 'LoginController',
                'method' => 'getLoginForm'
                ],
            'POST' =>
                [
                'class' => 'LoginController',
                'method' => 'loginUser'
                ]
            ],

        '/register' =>
            [
            'GET' =>
                [
                'class' => 'UserController',
                'method' => 'getRegistrateForm'
                ],
            'POST' =>
                [
                'class' => 'UserController',
                'method' => 'registrate'
                ]
            ],

        '/catalog' =>
            [
            'GET' =>
                [
                'class' => 'ProductController',
                'method' => 'getCatalog'
                ]
            ],

        '/order' =>
            [
            'GET' =>
                [
                'class' => 'OrderController',
                'method' => 'getOrderForm'
                ],
            'POST' =>
                [
                'class' => 'OrderController',
                'method' => 'createOrder'
                ]
            ],

        '/add' =>
            [
            /*'GET' =>
                [
                'class' => 'ProductController',
                'method' => 'getAddProductForm'
                ],*/
            'POST' =>
                [
                'class' => 'ProductController',
                'method' => 'addProductToCart'
                ]
            ],

        '/logout' =>
            [
            'GET' =>
                [
                'class' => 'LoginController',
                'method' => 'logoutUser'
                ]
            ],

        '/cart' =>
            [
            'GET' =>
                [
                'class' => 'CartController',
                'method' => 'lookCart'
                ]
            ],
    ];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $location => $method) {
            if ($requestUri === $location) {
                if (isset($method[$requestMethod])) {
                    $controllerClassName = $method[$requestMethod]['class'];
                    $method = $method[$requestMethod]['method'];

                    $class = new $controllerClassName();
                    return $class->$method();
                } else {
                    echo "$requestMethod не поддерживается для $requestUri";
                }
            }
        }
        http_response_code(404);
        require_once "./../View/404.php";
    }
}