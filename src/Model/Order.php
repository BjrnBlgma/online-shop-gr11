<?php

class Order
{
    public function createOrder($userId, $productId, $amount, $name, $family, $city, $address, $phone, $email) //добавить переменные для добавления информации в табицу Order
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, amount, name, family, city, address, phone, email) VALUES (:user_id, :product_id, :amount, :name, :family, :city, :address,:phone, :email)"); //добавить переменные для добавления информации в табицу Order
        $stmt->execute(['user_id'=> $userId, 'product_id'=>$productId, 'amount'=> $amount, 'name' => $name, 'family' => $family, 'city'=> $city, 'address'=> $address, 'phone'=> $phone, 'email' => $email]);
    }


    /*public function createOrder($userId, $productId, $amount, $name, $family, $selection, $city, $address, $region, $index, $phone, $email) //добавить переменные для добавления информации в табицу Order
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO orders
            (user_id, product_id, amount, name, family, selection, city, address, region, index, phone, email)
            VALUES (:user_id, :product_id, :amount, :name, :family, :selection, :city, :address, :region, :index, :phone, :email)"); //добавить переменные для добавления информации в табицу Order
        $stmt->execute(['user_id'=> $userId,
            'product_id'=>$productId,
            'amount'=> $amount,
            'name' => $name,
            'family' => $family,
            'selection' => $selection,
            'city'=> $city,
            'address'=> $address,
            'region'=> $region,
            'index'=> $index,
            'phone'=> $phone,
            'email' => $email]);
    }*/

    public function getByUserIdAndProductId($userId, $productId)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $isProductInCart = $stmt->fetch();

        return $isProductInCart;
    }

}