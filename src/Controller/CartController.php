<?php
namespace Controller;
use Model\UserProduct;

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
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];

//        $productsInCart = $this->userProduct->getByUserIdWithoutJoin($userId);
        $productsInCart = $this->userProduct->getByUserIdWithJoin($userId);

        //print_r($productsInCart);
        $allSum= $this->allSum();

        require_once "./../View/cart.php";
    }

    public function allSum()
    {
        $userId = $_SESSION['user_id'];

        $productsInCart = $this->userProduct->getByUserIdWithoutJoin($userId);

        $allSum=0;
        foreach($productsInCart as $product){
            $sum = $product->getProduct()->getPrice() * $product->getAmount();
            $allSum += $sum;
        }
        return $allSum;
    }
}