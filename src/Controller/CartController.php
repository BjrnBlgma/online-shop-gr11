<?php
require_once "./../Model/UserProduct.php";
class CartController
{
    private UserProduct $userProduct;

    public function __construct()
    {
        $this->userProduct = new UserProduct();
    }
    public function lookCart()
    {
        session_start();
        $userId = $_SESSION['user_id'];

        $productsInCart = $this->userProduct->getByUserId($userId);

        $allSum=0;
        foreach($productsInCart as $product){
            $sum = $product['product_price'] * $product['user_products_amount'];
            $allSum += $sum;
        }

        require_once "./../View/cart.php";
    }
}