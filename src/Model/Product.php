<?php
class Product
{
    public function getByProductId(int $productId)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        $isCorrectIdProduct = $stmt->fetch();

        return $isCorrectIdProduct;
    }

    public function getProducts(): array
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }
}