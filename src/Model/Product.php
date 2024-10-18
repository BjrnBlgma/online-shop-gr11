<?php
namespace Model;

class Product extends Model
{
    public function getByProductId(int $productId): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetch();
    }

    public function getProducts(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }
}