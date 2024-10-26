<?php
namespace Service;
use Model\UserProduct;
class CartService
{
    public static function totalSum($userId)
    {
        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);

        $allSum=0;
        foreach($productsInCart as $product){
            $sum = $product->getProduct()->getPrice() * $product->getAmount();
            $allSum += $sum;
        }
        return $allSum;
    }
    public static function checkProductInCart($userId, $productId, $amount)
    {
        $isProductInCart = UserProduct::getByUserIdAndProductId($userId, $productId); //есть ли продукт в козрине или нет
        if (empty($isProductInCart)) {
            UserProduct::addProductToCart($userId, $productId, $amount); // Добавляем товар
            //$this->userProductWishlist->deleteProduct($userId, $productId);
        } else {
            $newAmount = $amount + $isProductInCart->getAmount();
            UserProduct::plusProductAmountInCart($userId, $productId, $newAmount);
            //$this->userProductWishlist->deleteProduct($userId, $productId);
        }
    }
}