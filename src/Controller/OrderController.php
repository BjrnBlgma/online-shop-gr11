<?php
namespace Controller;

use Model\Order;

use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;


class OrderController
{
    public function getOrderForm()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else{
            $allSum = CartService::totalSum($userId);
            require_once "./../View/order.php";
        }
    }

    public function createOrder(OrderRequest $request)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
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