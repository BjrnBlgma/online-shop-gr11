<?php


class Product
{
    private $pdo;
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnectPdo();
    }

    public function getByProductId(int $productId)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM products WHERE id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        $isCorrectIdProduct = $stmt->fetch();

        return $isCorrectIdProduct;
    }

    public function getProducts(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }
}