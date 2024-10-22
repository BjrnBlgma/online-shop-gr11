<?php
namespace Model;

class OrderProduct extends Model
{
    public function sendProductToOrder(int $orderId, int $product, int $amount, int $price): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $product, 'amount' => $amount, 'price'=> $price]);
    }
}