<?php
require_once "./../Database/Database.php";


class Order
{
    private $pdo;
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnectPdo();
    }

    public function createOrderId($name, $family, $city, $address, $phone, $email, $userId) //добавить переменные для добавления информации в табицу Order
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (name, family, city, address, phone, email, user_id) VALUES (:name, :family, :city, :address, :phone, :email, :user_id)"); //добавить переменные для добавления информации в табицу Order
        $stmt->execute(['name' => $name, 'family' => $family, 'city'=> $city, 'address'=> $address, 'phone'=> $phone, 'email' => $email, 'user_id'=> $userId]);
    }


    public function getByUserIdToTakeOrderId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $sendOrderId = $stmt->fetch();

        return $sendOrderId;
    }

}