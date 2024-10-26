<?php
namespace Service;
use Model\UserProductWishlist;

class WishlistService
{
    public static function deleteProductFromWishlist($userId, $productId)
    {
        $isProductInWishlist = UserProductWishlist::getByUserIdAndProductId($userId, $productId);
        if ($isProductInWishlist) {
            UserProductWishlist::deleteProduct($userId, $productId);
        }
    }


    public static function checkProductInWishlist($userId, $productId)
    {
        $isProductInWishlist = UserProductWishlist::getByUserIdAndProductId($userId, $productId); //есть ли продукт или нет

        if ($isProductInWishlist === false) {
            UserProductWishlist::addProductToWishlist($userId, $productId); // Добавляем
            header('Location: /wishlist');
            exit;
        } else{
//            $newAmount = $amount + $isProductInWishlist['amount'];
//            $this->wishlist->plusProductAmountInCart($userId, $productId, $newAmount);
            $errors['product'] = 'Product already in wishlist';
            header('Location: /wishlist');
            exit;
        }
    }
}