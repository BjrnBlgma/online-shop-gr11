<?php
namespace Controller;
use Model\UserProduct;
use Request\ProductRequest;
use Service\CartService;
use Service\Session;

class CartController
{
    public function lookCart()
    {
        Session::start();
        Session::checkSessionUser();
        $userId = Session::getSessionUser();

//        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);
        $productsInCart = UserProduct::getByUserIdWithJoin($userId);

        $allSum= CartService::totalSum($userId);

        require_once "./../View/cart.php";
    }

    public function addProductToCart(ProductRequest $request)
    {
        Session::start();
        Session::checkSessionUser();
        $userId = Session::getSessionUser();
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