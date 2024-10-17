<?php
namespace Model;

class Order extends Model
{
    public function createOrderId($name, $family, $city, $address, $phone, $sum, $userId) //добавить переменные для добавления информации в табицу Order
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (name, family, city, address, phone, sum, user_id) VALUES (:name, :family, :city, :address, :phone, :sum, :user_id)"); //добавить переменные для добавления информации в табицу Order
        $stmt->execute(['name' => $name, 'family' => $family, 'city'=> $city, 'address'=> $address, 'phone'=> $phone, 'sum' => $sum, 'user_id'=> $userId]);
    }


    public function getByUserIdToTakeOrderId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $sendOrderId = $stmt->fetch();

        return $sendOrderId;
    }

}