<?php
require_once "./../Core/Autoload.php";
use Core\App;
use Core\Autoload;
use Controller\LoginController;
use Controller\UserController;
use Controller\ProductController;
use Controller\CartController;
use Controller\OrderController;
use Controller\WishlistController;

Autoload::registrate("/var/www/html/src/");

$app = new App();
$app->createRoute('/login', 'GET', LoginController::class, 'getLoginForm');
$app->createRoute('/login', 'POST', LoginController::class,'loginUser');
$app->createRoute('/register', 'GET', UserController::class, 'getRegistrateForm');
$app->createRoute('/register', 'POST', UserController::class, 'registrate');
$app->createRoute('/catalog', 'GET', ProductController::class, 'getCatalog');
$app->createRoute('/order', 'GET', ProductController::class, 'getOrderForm');
$app->createRoute('/order', 'POST', OrderController::class, 'createOrder');

$app->createRoute('/add', 'POST', ProductController::class,  'addProductToCart');
$app->createRoute('/logout', 'GET', LoginController::class,  'logoutUser');
$app->createRoute('/cart', 'GET', CartController::class, 'lookCart');

$app->createRoute('/addToWishlist', 'POST', WishlistController::class, 'addProductToWishlist');

//$app->createRoute('/addFromWishlist', 'POST', '\Controller\WishlistController', 'addFromWishlistToCart');
$app->createRoute('/wishlist', 'GET', WishlistController::class, 'lookWishlist');
$app->createRoute('/deleteFromWishlist', 'POST', WishlistController::class,'deleteProductFromWishlist');

$app->run();

