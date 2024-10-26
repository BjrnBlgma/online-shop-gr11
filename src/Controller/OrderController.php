<?php
namespace Controller;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Controller\CartController;
use Request\OrderRequest;


class OrderController
{
    private CartController $cartController;
    public function __construct()
    {
        $this->cartController = new CartController();
    }

    public function getOrderForm()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else{
            $allSum = $this->cartController->allSum();
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
        $allSum = $this->cartController->allSum();
        require_once "./../View/order.php";
    }
}