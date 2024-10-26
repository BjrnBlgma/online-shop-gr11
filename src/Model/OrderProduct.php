<?php
namespace Model;

class OrderProduct extends Model
{
    public static function sendProductToOrder(int $orderId, Product $product, int $amount): void
    {
        $stmt = self::getPdo()->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $product->getId(), 'amount' => $amount, 'price'=> $product->getPrice()]);
    }
}