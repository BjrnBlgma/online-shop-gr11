<?php
require_once "./../Core/Autoload.php";

use Controller\CartController;
use Controller\LoginController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Controller\WishlistController;
use Core\App;
use Core\Autoload;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\ProductRequest;
use Request\RegistrateRequest;
use Request\WishlistRequest;
use Service\Logger\LoggerFileService;


Autoload::registrate("/var/www/html/src/");

$loggerService = new LoggerFileService();
$app = new App($loggerService);

$app->createRoute('/login', 'GET', LoginController::class, 'getLoginForm');
$app->postRoute('/login', LoginController::class,'loginUser', LoginRequest::class);

$app->createRoute('/register', 'GET', UserController::class, 'getRegistrateForm');
$app->postRoute('/register', UserController::class, 'registrate', RegistrateRequest::class);

$app->createRoute('/catalog', 'GET', ProductController::class, 'getCatalog');

$app->createRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->postRoute('/order', OrderController::class, 'createOrder', OrderRequest::class);

$app->postRoute('/add', CartController::class,  'addProductToCart', ProductRequest::class);
$app->createRoute('/logout', 'GET', LoginController::class,  'logoutUser');
$app->createRoute('/cart', 'GET', CartController::class, 'lookCart');

$app->postRoute('/addToWishlist',WishlistController::class, 'addProductToWishlist', WishlistRequest::class);

$app->postRoute('/addFromWishlist', '\Controller\WishlistController', 'addFromWishlistToCart', WishlistRequest::class);
$app->createRoute('/wishlist', 'GET', WishlistController::class, 'lookWishlist');
$app->createRoute('/deleteFromWishlist', 'POST', WishlistController::class,'deleteProductFromWishlist');

$app->run();

