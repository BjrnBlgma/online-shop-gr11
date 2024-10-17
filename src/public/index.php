<?php
require_once "./../Core/Autoload.php";
use Core\App;
use Core\Autoload;
use Controller\LoginController;

Autoload::registrate("/var/www/html/src/");

$app = new App();
$app->createRoute('/login', 'GET', LoginController::class, 'getLoginForm');
$app->createRoute('/login', 'POST', LoginController::class, 'loginUser');
$app->createRoute('/register', 'GET', '\Controller\UserController', 'getRegistrateForm');
$app->createRoute('/register', 'POST', '\Controller\UserController', 'registrate');
$app->createRoute('/catalog', 'GET', '\Controller\ProductController', 'getCatalog');
$app->createRoute('/order', 'GET', '\Controller\OrderController', 'getOrderForm');
$app->createRoute('/order', 'POST', '\Controller\OrderController', 'createOrder');
$app->createRoute('/add', 'POST', '\Controller\ProductController', 'addProductToCart');
$app->createRoute('/logout', 'GET', '\Controller\UserController', 'logoutUser');
$app->createRoute('/cart', 'GET', '\Controller\CartController', 'lookCart');

$app->run();

