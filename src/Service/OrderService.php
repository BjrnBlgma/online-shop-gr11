<?php
namespace Service;

use DTO\CreateOrderDTO;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Model\Model;

class OrderService
{
    public function create(CreateOrderDTO $orderDTO)
    {
        Model::getPdo()->beginTransaction();
        try {
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
            //throw new \Exception();

            $userProducts = UserProduct::getByUserIdWithJoin($orderDTO->getUserId());
            foreach ($userProducts as $elem) {
                OrderProduct::sendProductToOrder($orderId, $elem->getProduct(), $elem->getAmount());
            }
            UserProduct::cleaneCart($orderDTO->getUserId());
        } catch (\PDOException $exception) {
            Model::getPdo()->rollBack();
            throw $exception;
        }
        Model::getPdo()->commit();
    }
}