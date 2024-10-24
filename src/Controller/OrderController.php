<?php
namespace Controller;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Controller\CartController;
use Request\OrderRequest;


class OrderController
{
    private UserProduct $userProduct;
    private Order $order;
    private OrderProduct $orderProduct;
    private CartController $cartController;
    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->order = new Order();
        $this->orderProduct = new OrderProduct();
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

            $this->order->createOrderId($name, $family, $city, $address, $phone, $sum, $userId);

            $orderIdObj = $this->order->getByUserIdToTakeOrderId($userId);
            $orderId = $orderIdObj->getId();

//            $userProducts = $this->userProduct->getByUserIdWithoutJoin($userId);
//            foreach($userProducts as $elem){
//                $this->orderProduct->sendProductToOrder($orderId, $elem->getProduct() , $elem->getAmount() );
//            }

            $userProducts = $this->userProduct->getByUserIdWithJoin($userId);
            foreach ($userProducts as $elem) {
                $this->orderProduct->sendProductToOrder($orderId, $elem->getProduct(), $elem->getAmount());
            }


            $this->userProduct->deleteProduct($userId); // Удаляем товар из корзины, п.ч. сделали заказ
            header('Location: /cart');

        }
        $allSum = $this->cartController->allSum();
        require_once "./../View/order.php";
    }
}