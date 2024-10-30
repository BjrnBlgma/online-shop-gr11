<?php
namespace DTO;

class CreateOrderDTO
{
    public function __construct(
        private string $name,
        private string $family,
        private string $city,
        private string $address,
        private string $phone,
        private int|float $sum,
        private int $userId
    ){}

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

    public function getSum(): float|int
    {
        return $this->sum;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }


}