<?php
namespace Ariana\FirstProject\Service;
use Ariana\FirstProject\Model\UserProduct;

class CartService
{
    public function getTotalSum(int $userId)
    {
        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);

        $allSum=0;
        foreach($productsInCart as $product){
            $sum = $product->getProduct()->getPrice() * $product->getAmount();
            $allSum += $sum;
        }
        return $allSum;
    }
    public function addProductToCart(int $userId, int $productId, int $amount)
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