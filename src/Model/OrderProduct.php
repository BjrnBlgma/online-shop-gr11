<?php
require_once "./../Database/Database.php";

class OrderProduct
{
    private $pdo;
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnectPdo();
    }

    public function sendProductToOrder(int $orderId, int $product, int $amount, int $price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $product, 'amount' => $amount, 'price'=> $price]);
    }
}