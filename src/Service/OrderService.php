<?php
namespace Ariana\FirstProject\Service;

use DTO\CreateOrderDTO;
use Ariana\FirstProject\Model\Order;
use Ariana\FirstProject\Model\UserProduct;
use Ariana\FirstProject\Model\OrderProduct;
use Core\Model;

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
            $userProducts = UserProduct::getByUserIdWithoutJoin($orderDTO->getUserId()); //проверить, так как переделала на безджоин
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