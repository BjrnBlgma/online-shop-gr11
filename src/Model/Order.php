<?php
namespace Ariana\FirstProject\Model;
use Core\Model;

class Order extends Model
{
    private int $id;
    private string $name;
    private string $family;
    private string $city;
    private string $address;
    private string $phone;
    private int|float $sumTotal;
    private int $userId;

    public static function createOrderId(
        string $name,
        string $family,
        string $city,
        string $address,
        string $phone,
        int|float $sum,
        int $userId
    )
    {
        $stmt = self::getPdo()->prepare("INSERT INTO orders (name, family, city, address, phone, sum, user_id) VALUES (:name, :family, :city, :address, :phone, :sum, :user_id)");
        $stmt->execute(['name' => $name, 'family' => $family, 'city'=> $city, 'address'=> $address, 'phone'=> $phone, 'sum' => $sum, 'user_id'=> $userId]);
    }


    public static function getByUserIdToTakeOrderId(int $userId): self|null
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC');
        $stmt->execute(['user_id' => $userId]);
        $sendOrderId = $stmt->fetch();

        if (empty($sendOrderId)) {
            return null;
        }
        return self::hydrate($sendOrderId);
    }

    public static function getById(int $orderId): self|null
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM orders WHERE id = :id');
        $stmt->execute(['id' => $orderId]);
        $sendOrderId = $stmt->fetch();

        if (empty($sendOrderId)) {
            return null;
        }
        return self::hydrate($sendOrderId);
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

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getSumTotal(): int|float
    {
        return $this->sumTotal;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): Order
    {
        $this->name = $name;
        return $this;
    }

    public function setFamily(string $family): Order
    {
        $this->family = $family;
        return $this;
    }

    public function setCity(string $city): Order
    {
        $this->city = $city;
        return $this;
    }

    public function setAddress(string $address): Order
    {
        $this->address = $address;
        return $this;
    }

    public function setPhone(string $phone): Order
    {
        $this->phone = $phone;
        return $this;
    }

    public function setSumTotal(float|int $sumTotal): Order
    {
        $this->sumTotal = $sumTotal;
        return $this;
    }

    public function setUserId(int $userId): Order
    {
        $this->userId = $userId;
        return $this;
    }



    private static function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->family = $data['family'];
        $obj->city = $data['city'];
        $obj->address = $data['address'];
        $obj->phone = $data['phone'];
        $obj->sumTotal = $data['sum'];
        $obj->userId = $data['user_id'];
        return $obj;
    }

}