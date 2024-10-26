<?php
namespace Controller;
use Model\UserProduct;
use Request\ProductRequest;
use Service\CartService;

class CartController
{
    public function lookCart()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];

//        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);
        $productsInCart = UserProduct::getByUserIdWithJoin($userId);

        $allSum= CartService::totalSum($userId);

        require_once "./../View/cart.php";
    }

    public function addProductToCart(ProductRequest $request)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $errors = $request->validate();

        if (empty($errors)) {
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            CartService::checkProductInCart($userId, $productId, $amount);
            header('Location: /cart');
            exit;
        }

        require_once "./../View/add_product.php";
    }
}