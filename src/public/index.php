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
use Core\Container;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\ProductRequest;
use Request\RegistrateRequest;
use Request\WishlistRequest;
use Service\Authentication\AuthSessionService;
use Service\Authentication\AuthServiceInterface;
use Service\Authentication\AuthCookieService;
use Service\CartService;
use Service\Logger\LoggerFileService;
use Service\Logger\LoggerDbService;
use Service\Logger\LoggerServiceInterface;
use Service\OrderService;
use Service\WishlistService;

try{
    Autoload::registrate("/var/www/html/src/");

    $container = new Container();

    $container->set(LoginController::class, function (Container $container) {
        $authService = $container->get(AuthServiceInterface::class);
        return new LoginController($authService);
    });

    $container->set(ProductController::class, function (Container $container) {
        $authService = $container->get(AuthServiceInterface::class);
        return new ProductController($authService);
    });

    $container->set(OrderController::class, function (Container $container) {
        $authService = $container->get(AuthServiceInterface::class);
        $cartService = new CartService();
        $orderService = new OrderService();
        return new OrderController($authService, $cartService, $orderService);
    });

    $container->set(CartController::class, function (Container $container) {
        $authService = $container->get(AuthServiceInterface::class);
        $cartService = new CartService();
        return new CartController($authService, $cartService);
    });

    $container->set(WishlistController::class, function (Container $container) {
        $authService = $container->get(AuthServiceInterface::class);
        $cartService = new CartService();
        $wishlistService = new WishlistService();
        return new WishlistController($authService, $cartService, $wishlistService);
    });

    $container->set(LoggerServiceInterface::class, function () {
        return new LoggerFileService();
    });

    $container->set(AuthServiceInterface::class, function () {
        return new AuthSessionService();
    });

    $loggerService = $container->get(LoggerServiceInterface::class);
    $app = new App($loggerService, $container);

    $app->createRoute('/login', 'GET', LoginController::class, 'getLoginForm');
    $app->postRoute('/login', LoginController::class,'loginUser', LoginRequest::class);
    $app->createRoute('/logout', 'GET', LoginController::class,  'logoutUser');

    $app->createRoute('/register', 'GET', UserController::class, 'getRegistrateForm');
    $app->postRoute('/register', UserController::class, 'registrate', RegistrateRequest::class);

    $app->createRoute('/catalog', 'GET', ProductController::class, 'getCatalog');

    $app->getRoute('/order', OrderController::class, 'getOrderForm');
    $app->postRoute('/order', OrderController::class, 'createOrder', OrderRequest::class);

    $app->postRoute('/add', CartController::class, 'addProductToCart', ProductRequest::class);
    $app->createRoute('/cart', 'GET',CartController::class, 'lookCart');

    $app->postRoute('/addToWishlist', WishlistController::class, 'addProductToWishlist', WishlistRequest::class);
    $app->postRoute('/addFromWishlist', WishlistController::class, 'addFromWishlistToCart', WishlistRequest::class,);
    $app->createRoute('/wishlist', 'GET', WishlistController::class, 'lookWishlist');
    $app->createRoute('/deleteFromWishlist', 'POST', WishlistController::class, 'deleteProductFromWishlist');

    $app->run();
} catch (\Error $exception){
    http_response_code(500);
    require_once "./../View/500.php";

    $loggerService = $container->get(LoggerServiceInterface::class);
    $loggerService->error(
        'Произошла ошибка при обработке',
        [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]
    );
}