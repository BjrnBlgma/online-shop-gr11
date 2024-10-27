<?php
namespace Controller;
use Model\UserProduct;
use Request\ProductRequest;
use Service\CartService;
use Service\Authentication;

class CartController
{
    public function lookCart()
    {
        Authentication::start();
        Authentication::checkSessionUser();
        $userId = Authentication::getSessionUser();

//        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);
        $productsInCart = UserProduct::getByUserIdWithJoin($userId);

        $allSum= CartService::totalSum($userId);

        require_once "./../View/cart.php";
    }

    public function addProductToCart(ProductRequest $request)
    {
        Authentication::start();
        Authentication::checkSessionUser();
        $userId = Authentication::getSessionUser();
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