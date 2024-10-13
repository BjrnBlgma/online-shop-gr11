<?php

class OrderProduct
{
    public function sendProductToOrder(int $orderId, int $product, int $amount, int $price)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $product, 'amount' => $amount, 'price'=> $price]);
    }
}