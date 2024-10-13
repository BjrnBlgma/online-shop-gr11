<?php

class Order
{
    public function createOrderId($name, $family, $city, $address, $phone, $email, $userId) //добавить переменные для добавления информации в табицу Order
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO orders (name, family, city, address, phone, email, user_id) VALUES (:name, :family, :city, :address, :phone, :email, :user_id)"); //добавить переменные для добавления информации в табицу Order
        $stmt->execute(['name' => $name, 'family' => $family, 'city'=> $city, 'address'=> $address, 'phone'=> $phone, 'email' => $email, 'user_id'=> $userId]);
    }


    public function getByUserIdToTakeOrderId($userId)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $sendOrderId = $stmt->fetch();

        return $sendOrderId;
    }

}