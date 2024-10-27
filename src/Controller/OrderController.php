<?php
namespace Controller;

use Model\Order;
use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;
use Service\Authentication;

class OrderController
{
    public function getOrderForm()
    {
        Authentication::start();
        $userId = Authentication::getSessionUser();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            $allSum = CartService::totalSum($userId);
            require_once "./../View/order.php";
        }
    }

    public function createOrder(OrderRequest $request)
    {
        Authentication::start();
        Authentication::checkSessionUser();
        $userId = Authentication::getSessionUser();
        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $family = $request->getFamily();
            $address = $request->getAddress();
            $city = $request->getCity();
            $phone = $request->getPhone();
            $sum = $request->getTotalSum();

            Order::createOrderId($name, $family, $city, $address, $phone, $sum, $userId);

            OrderService::addProductsToOrderByUserId($userId);
        }
        $allSum = CartService::totalSum($userId);
        require_once "./../View/order.php";
    }
}