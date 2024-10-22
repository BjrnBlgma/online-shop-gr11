<?php
namespace Model;

class Order extends Model
{
    private int $id;
    private string $name;
    private string $family;
    private string $city;
    private string $address;
    private int $phone;
    private int $sumTotal;
    private int $userId;

    public function createOrderId($name, $family, $city, $address, $phone, $sum, $userId) //добавить переменные для добавления информации в табицу Order
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (name, family, city, address, phone, sum, user_id) VALUES (:name, :family, :city, :address, :phone, :sum, :user_id)"); //добавить переменные для добавления информации в табицу Order
        $stmt->execute(['name' => $name, 'family' => $family, 'city'=> $city, 'address'=> $address, 'phone'=> $phone, 'sum' => $sum, 'user_id'=> $userId]);
    }


    public function getByUserIdToTakeOrderId($userId): self|null
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC');
        $stmt->execute(['user_id' => $userId]);
        $sendOrderId = $stmt->fetch();

        if (empty($sendOrderId)) {
            return null;
        }
        return $this->hydrate($sendOrderId);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamily(): string
    {
        return $this->family;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function getSumTotal(): int
    {
        return $this->sumTotal;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }



    private function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->family = $data['family'];
        $obj->city = $data['city'];
        $obj->address = $data['address'];
        $obj->phone = $data['phone'];
        $obj->sumTotal = $data['sumTotal'];
        $obj->userId = $data['userId'];

        return $obj;
    }

}