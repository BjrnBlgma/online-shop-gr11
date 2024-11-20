<?php
namespace Ariana\FirstProject\Service;
use Ariana\FirstProject\Model\UserProductWishlist;

class WishlistService
{
    public function deleteProductFromWishlist(int $userId, int $productId)
    {
        $isProductInWishlist = UserProductWishlist::getByUserIdAndProductId($userId, $productId);
        if ($isProductInWishlist) {
            UserProductWishlist::deleteProduct($userId, $productId);
        }
    }


    public function addProductToWishlist(int $userId, int $productId)
    {
        $isProductInWishlist = UserProductWishlist::getByUserIdAndProductId($userId, $productId); //есть ли продукт или нет

        if ($isProductInWishlist === false) {
            UserProductWishlist::addProductToWishlist($userId, $productId); // Добавляем
        } else{
            $errors['product'] = 'Product already in wishlist';
        }
    }
}