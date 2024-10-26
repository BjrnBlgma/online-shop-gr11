<?php
namespace Service;

use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;

class OrderService
{
    public static function addProductsToOrderByUserId($userId){
        $orderIdObj = Order::getByUserIdToTakeOrderId($userId);
        $orderId = $orderIdObj->getId();

//            $userProducts = $this->userProduct->getByUserIdWithoutJoin($userId);
//            foreach($userProducts as $elem){
//                $this->orderProduct->sendProductToOrder($orderId, $elem->getProduct() , $elem->getAmount() );
//            }

        $userProducts = UserProduct::getByUserIdWithJoin($userId);
        foreach ($userProducts as $elem) {
            OrderProduct::sendProductToOrder($orderId, $elem->getProduct(), $elem->getAmount());
        }

        UserProduct::deleteProduct($userId); // Удаляем товар из корзины, п.ч. сделали заказ
        header('Location: /cart');
    }
}