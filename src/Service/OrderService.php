<?php
namespace Service;

use DTO\CreateOrderDTO;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;

class OrderService
{
    public function create(CreateOrderDTO $orderDTO)
    {
        Order::createOrderId(
            $orderDTO->getName(),
            $orderDTO->getFamily(),
            $orderDTO->getCity(),
            $orderDTO->getAddress(),
            $orderDTO->getPhone(),
            $orderDTO->getSum(),
            $orderDTO->getUserId()
        );

        $orderIdObj = Order::getByUserIdToTakeOrderId($orderDTO->getUserId());
        $orderId = $orderIdObj->getId();

        $userProducts = UserProduct::getByUserIdWithJoin($orderDTO->getUserId());
        foreach ($userProducts as $elem) {
            OrderProduct::sendProductToOrder($orderId, $elem->getProduct(), $elem->getAmount());
        }
        UserProduct::deleteProduct($orderDTO->getUserId()); // Удаляем товар из корзины, п.ч. сделали заказ
    }
}