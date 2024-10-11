<?php

class Order
{
    public function createOrder($name, $family, $email) //добавить переменные для добавления информации в табицу Order
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO order (name, email, password) VALUES (:name, :family, :email)"); //добавить переменные для добавления информации в табицу Order
        $stmt->execute(['name' => $name, 'family' => $family, 'email' => $email]);
    }

    public function getByUserIdAndProductId($userId, $productId)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $isProductInCart = $stmt->fetch();

        return $isProductInCart;
    }

}