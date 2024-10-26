<?php

namespace Model;

class UserProductWishlist extends Model
{
    public static function getByUserIdAndProductId(int $userId, int $productId)
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM user_products_wishlist WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $isProductInCart = $stmt->fetch();

        return $isProductInCart;
    }

    public static function addProductToWishlist(int $user, int $product)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO user_products_wishlist (user_id, product_id) VALUES (:userId, :productId)");
        $stmt->execute([ 'userId' => $user, 'productId' => $product]);
    }

    public static function plusProductAmountInCart(int $user, int $product, int $amount)
    {
        $stmt = self::getPdo()->prepare("UPDATE user_products_wishlist SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['userId' => $user, 'productId' => $product, 'amount' => $amount]);
    }

    public static function getWishlistByUserId(int $user)
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM user_products_wishlist WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user]);

        $res = $stmt->fetchAll();
        return $res;
    }

    public static function deleteProduct(int $user, int $product)
    {
        $stmt = self::getPdo()->prepare( "DELETE FROM user_products_wishlist WHERE user_id = :user_id AND product_id = :product");
        $stmt->execute(['user_id' => $user, 'product' => $product]);
    }
}