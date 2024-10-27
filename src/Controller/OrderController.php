<?php
namespace Controller;

use Model\Order;

use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;

use Session\Session;

class OrderController
{
    public function getOrderForm()
    {
        Session::start();
        $userId = Session::getSessionUser();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            $allSum = CartService::totalSum($userId);
            require_once "./../View/order.php";
        }
    }

    public function createOrder(OrderRequest $request)
    {
        Session::start();
        Session::checkSessionUser();
        $userId = Session::getSessionUser();
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