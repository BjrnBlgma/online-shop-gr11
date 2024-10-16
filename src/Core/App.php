<?php
/*require_once "./../Controller/UserController.php";
require_once "./../Controller/CartController.php";
require_once "./../Controller/ProductController.php";
require_once "./../Controller/LoginController.php";
require_once './../Controller/OrderController.php';*/

namespace Core;


class App
{
    private array $routes = [
        '/login' =>
            [
            'GET' =>
                [
                'class' => '\Controller\LoginController',
                'method' => 'getLoginForm'
                ],
            'POST' =>
                [
                'class' => '\Controller\LoginController',
                'method' => 'loginUser'
                ]
            ],

        '/register' =>
            [
            'GET' =>
                [
                'class' => '\Controller\UserController',
                'method' => 'getRegistrateForm'
                ],
            'POST' =>
                [
                'class' => '\Controller\UserController',
                'method' => 'registrate'
                ]
            ],

        '/catalog' =>
            [
            'GET' =>
                [
                'class' => '\Controller\ProductController',
                'method' => 'getCatalog'
                ]
            ],

        '/order' =>
            [
            'GET' =>
                [
                'class' => 'Controller\OrderController',
                'method' => 'getOrderForm'
                ],
            'POST' =>
                [
                'class' => '\Controller\OrderController',
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
                'class' => '\Controller\ProductController',
                'method' => 'addProductToCart'
                ]
            ],

        '/logout' =>
            [
            'GET' =>
                [
                'class' => '\Controller\LoginController',
                'method' => 'logoutUser'
                ]
            ],

        '/cart' =>
            [
            'GET' =>
                [
                'class' => '\Controller\CartController',
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