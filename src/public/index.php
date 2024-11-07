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
use Service\Authentication\AuthSessionService;
use Service\CartService;
use Service\Logger\LoggerFileService;
use Service\OrderService;
use Service\WishlistService;

try{
    Autoload::registrate("/var/www/html/src/");

    $loggerService = new LoggerFileService();
    $app = new App($loggerService);

    $app->createRoute('/login', 'GET', LoginController::class, 'getLoginForm', null, [AuthSessionService::class]);
    $app->postRoute('/login', LoginController::class,'loginUser', LoginRequest::class, [AuthSessionService::class]);

    $app->createRoute('/register', 'GET', UserController::class, 'getRegistrateForm');
    $app->postRoute('/register', UserController::class, 'registrate', RegistrateRequest::class);

    $app->createRoute('/catalog', 'GET', ProductController::class, 'getCatalog', null, [AuthSessionService::class]);

    $app->getRoute('/order', OrderController::class, 'getOrderForm', [AuthSessionService::class, CartService::class, OrderService::class]);
    $app->postRoute(
        '/order',
        OrderController::class,
        'createOrder',
        OrderRequest::class,
        [AuthSessionService::class, CartService::class, OrderService::class]
    );

    $app->postRoute(
        '/add',
        CartController::class,
        'addProductToCart',
        ProductRequest::class,
        [AuthSessionService::class, CartService::class]
    );
    $app->createRoute('/cart', 'GET',CartController::class, 'lookCart', null, [AuthSessionService::class, CartService::class]);

    $app->createRoute('/logout', 'GET', LoginController::class,  'logoutUser', null, [AuthSessionService::class]);
//$app->createRoute('/cart', 'GET', CartController::class, 'lookCart', null,[AuthSessionService::class, CartService::class]);

    $app->postRoute(
        '/addToWishlist',
        WishlistController::class,
        'addProductToWishlist',
        WishlistRequest::class,
        [AuthSessionService::class, CartService::class, WishlistService::class] //необходимо добавлять столько объектов, сколько вызывается в конструкторе
    );

    $app->postRoute(
        '/addFromWishlist',
        WishlistController::class,
        'addFromWishlistToCart',
        WishlistRequest::class,
        [AuthSessionService::class, CartService::class, WishlistService::class]
    );

    $app->createRoute(
        '/wishlist',
        'GET',
        WishlistController::class,
        'lookWishlist',
        null,
        [AuthSessionService::class, CartService::class, WishlistService::class]
    );

    $app->createRoute(
        '/deleteFromWishlist',
        'POST',
        WishlistController::class,
        'deleteProductFromWishlist',
        null,
        [AuthSessionService::class, CartService::class, WishlistService::class]
    );

    $app->run();
} catch (\Error $exception){
    http_response_code(500);
    require_once "./../View/500.php";

    $log = new LoggerFileService(); // подумать, как сделать более гибкую зависимость
    $log->error(
        'Произошла ошибка при обработке',
        [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]
    );
}