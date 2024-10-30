<?php
namespace Controller;

use DTO\CreateOrderDTO;
use Model\Order;
use Request\OrderRequest;
use Service\CartService;

use Service\OrderService;

use Service\Authentication;

class OrderController
{
    private Authentication $authentication;
    private CartService $cartService;
    private OrderService $orderService;
    public function __construct(){
        $this->authentication = new Authentication();
        $this->cartService = new CartService();
        $this->orderService = new OrderService();
    }


    public function getOrderForm()
    {
        $this->authentication->start();
        $userId = $this->authentication->getSessionUser();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            $allSum = $this->cartService->getTotalSum($userId); //если пустая корзина при оформлении заказа, то перенаправить в каталог
            if (empty($allSum)) {
                header('Location: /catalog');
            }
            require_once "./../View/order.php";
        }
    }

    public function createOrder(OrderRequest $request)
    {
        $this->authentication->start();
        $this->authentication->checkSessionUser();
        $userId = $this->authentication->getSessionUser();
        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $family = $request->getFamily();
            $address = $request->getAddress();
            $city = $request->getCity();
            $phone = $request->getPhone();
            $sum = $request->getTotalSum();

            $dto = new CreateOrderDTO($name, $family, $city, $address, $phone, $sum, $userId);
            $this->orderService->create($dto);

            header('Location: /cart');
        }
        $allSum = $this->cartService->getTotalSum($userId);
        require_once "./../View/order.php";
    }
}