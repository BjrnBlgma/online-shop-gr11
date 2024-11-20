<?php
namespace Ariana\FirstProject\Controller;

use DTO\CreateOrderDTO;
use Ariana\FirstProject\Request\OrderRequest;
use Core\Authentication\AuthServiceInterface;
use Ariana\FirstProject\Service\CartService;
use Ariana\FirstProject\Service\OrderService;

class OrderController
{
    private AuthServiceInterface $authentication;
    private CartService $cartService;
    private OrderService $orderService;

    public function __construct(
        AuthServiceInterface $authentication,
        CartService $cartService,
        OrderService $orderService
    )
    {
        $this->authentication = $authentication;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function getOrderForm()
    {
        if (!$this->authentication->checkSessionUser()) {
            header('Location: /login');
        } else{
            $userId = $this->authentication->getCurrentUser()->getId();
            $allSum = $this->cartService->getTotalSum($userId); //если пустая корзина при оформлении заказа, то перенаправить в каталог
            if (empty($allSum)) {
                header('Location: /catalog');
            }
            require_once "./../View/order.php";
        }
    }

    public function createOrder(OrderRequest $request)
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $userId = $this->authentication->getCurrentUser()->getId();
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