<?php
class CartController
{
    public function lookCart()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        require_once "./../Model/UserProduct.php";
        $userProduct = new UserProduct();
        $productInCart = $userProduct->getByUserId($userId);

        $allSum = $this->sumCart();

        require_once "./../View/cart.php";
    }


    private function sumCart(): int
    {
        $allSum=0;
        $userProducts = $this->lookCart();
        foreach($userProducts as $product){
            $sum = $product['product_price'] * $product['user_products_amount'];
            $allSum += $sum;
        }
        return $allSum;
    }
}