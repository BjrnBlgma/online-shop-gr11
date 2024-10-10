<?php
require_once "./../Controller/UserController.php";
require_once "./../Controller/CartController.php";
require_once "./../Controller/ProductController.php";
require_once "./../Controller/LoginController.php";

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri){
    case '/login':
        $loginController = new LoginController();
        if ($requestMethod === 'GET') {
            $loginController->getLoginForm();
        } elseif ($requestMethod === 'POST') {
            $loginController->loginUser();
        } else {
            echo "$requestMethod не поддерживается адресом $requestUri";
        }
        break;



    case '/registrate':
        $userController = new UserController();
        if ($requestMethod === 'GET'){
            $userController->getRegistrateForm();
        } elseif ($requestMethod === 'POST'){
            $userController->registrate();
        } else {
            echo "$requestMethod не поддерживается адресом $requestUri";
        }
        break;


    case '/catalog':
        if ($requestMethod === 'GET'){
            $productController = new ProductController();
            $productController->getCatalog();
        } else{
            echo "$requestMethod не поддерживается адресом $requestUri";
        }
        break;




    case '/add':
        $productController = new ProductController();
        if ($requestMethod === 'GET') {
            $productController->getAddProductForm();
        } elseif ($requestMethod === 'POST') {
            $productController->addProductToCart();
        } else{
            echo "$requestMethod не поддерживается адресом $requestUri";
        }
        break;


    case '/logout':
        if ($requestMethod === 'GET') {
            $loginController = new LoginController();
            $loginController->logoutUser();
        } else {
            echo "$requestMethod не поддерживается адресом $requestUri";
        }
        break;


    case '/cart':
        if ($requestMethod === 'GET'){
            $cartController = new CartController();
            $cartController->lookCart();
        } else {
            echo "$requestMethod не поддерживается адресом $requestUri";
        }
        break;


    default:
        http_response_code(404);
        require_once "./../View/404.php";}
