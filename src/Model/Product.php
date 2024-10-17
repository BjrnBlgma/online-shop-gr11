<?php
namespace Model;

class Product extends Model
{
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