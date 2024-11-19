<?php
require_once "./../../vendor/autoload.php";

use Controller\CartController;
use Controller\LoginController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\ReviewController;
use Controller\UserController;
use Controller\WishlistController;
use Core\App;
use Core\Autoload;
use Core\Container;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\ProductCardRequest;
use Request\ProductRequest;
use Request\RegistrateRequest;
use Request\ReviewRequest;
use Request\WishlistRequest;
use Service\Authentication\AuthSessionService;
use Service\Authentication\AuthServiceInterface;
use Service\Authentication\AuthCookieService;
use Service\CartService;
use Service\Logger\LoggerFileService;
use Service\Logger\LoggerDbService;
use Service\Logger\LoggerServiceInterface;
use Service\OrderService;
use Service\ReviewService;
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
        $reviewService = $container->get(ReviewService::class);
        return new ProductController($authService, $reviewService);
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

    $container->set(\Controller\ReviewController::class, function (Container $container) {
        $authService = $container->get(AuthServiceInterface::class);
        return new ReviewController($authService);
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
    $app->postRoute('/addFromWishlist', WishlistController::class, 'addFromWishlistToCart', WishlistRequest::class);
    $app->createRoute('/wishlist', 'GET', WishlistController::class, 'lookWishlist');
    $app->createRoute('/deleteFromWishlist', 'POST', WishlistController::class, 'deleteProductFromWishlist', WishlistRequest::class,);

    $app->postRoute('/product', ProductController::class, 'openProduct', ProductCardRequest::class);

    $app->postRoute('/review', \Controller\ReviewController::class, 'getReviewForm', ProductCardRequest::class);
    $app->postRoute('/add-review', \Controller\ReviewController::class, 'createReview', ReviewRequest::class);
    $app->run();
} catch (\Error $exception){
//    print_r($exception->getMessage() . "\n");
//    print_r($exception->getFile() . "\n");
//    print_r($exception->getLine() . "\n");
//    exit();
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