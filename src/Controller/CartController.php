<?php
namespace Controller;
use Model\UserProduct;
use Request\ProductRequest;

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

        //print_r($productsInCart);
        $allSum= $this->allSum();

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

            $isProductInCart = UserProduct::getByUserIdAndProductId($userId, $productId); //есть ли продукт в козрине или нет
            if (empty($isProductInCart)) {
                UserProduct::addProductToCart($userId, $productId, $amount); // Добавляем товар
                //$this->userProductWishlist->deleteProduct($userId, $productId);
                header('Location: /cart');
                exit;
            } else {
                $newAmount = $amount + $isProductInCart->getAmount();
                UserProduct::plusProductAmountInCart($userId, $productId, $newAmount);
                //$this->userProductWishlist->deleteProduct($userId, $productId);
                header('Location: /cart');
                exit;
            }
        }

        require_once "./../View/add_product.php";
    }

    public function allSum()
    {
        $userId = $_SESSION['user_id'];

        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);

        $allSum=0;
        foreach($productsInCart as $product){
            $sum = $product->getProduct()->getPrice() * $product->getAmount();
            $allSum += $sum;
        }
        return $allSum;
    }
}