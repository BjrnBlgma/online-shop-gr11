<?php
namespace Controller;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Controller\CartController;


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

    public function createOrder()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $errors = $this->validateOrder();

        if (empty($errors)) {
            $name = $_POST['firstName'];
            $family = $_POST['family'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $sum = $_POST['all_sum'];

            $this->order->createOrderId($name, $family, $city, $address, $phone, $sum, $userId);

            $orderIdObj = $this->order->getByUserIdToTakeOrderId($userId);
            $orderId = $orderIdObj->getId();

//            $userProducts = $this->userProduct->getByUserIdWithoutJoin($userId);
//            foreach($userProducts as $elem){
//                $this->orderProduct->sendProductToOrder($orderId, $elem->getProduct() , $elem->getAmount() );
//            }

            $userProducts = $this->userProduct->getByUserIdWithJoin($userId);
            foreach($userProducts as $elem){
                $this->orderProduct->sendProductToOrder($orderId, $elem->getProduct() , $elem->getAmount() );
            }


            $this->userProduct->deleteProduct($userId); // Удаляем товар из корзины, п.ч. сделали заказ
            header('Location: /cart');

        }
        $allSum = $this->cartController->allSum();
        require_once "./../View/order.php";
    }




    private function validateOrder(): array //переделать валидацию, после создания таблицы в бд
    {
        $errors = [];

        if (isset($_POST['firstName'])) {
            $name = htmlspecialchars($_POST['firstName'], ENT_QUOTES, 'UTF-8');
            if (empty($name)){
                $errors['firstName'] = "Имя не должно быть пустым";
            } elseif (strlen($name) < 3 || strlen($name) > 20) {
                $errors['firstName'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors['firstName'] = "Имя может содержать только буквы";
            }
        }else{
            $errors ['firstName'] = "Поле name должно быть заполнено";
        }


        if (isset($_POST['family'])) {
            $family = htmlspecialchars($_POST['family'], ENT_QUOTES, 'UTF-8');
            if (empty($family)){
                $errors['family'] = "Поле Фамилия не должно быть пустым";
            } elseif (strlen($family) < 3 || strlen($family) > 20) {
                $errors['family'] = "Фамилия должна содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $family)) {
                $errors['family'] = "Фамилия может содержать только буквы";
            }
        }else {
            $errors ['family'] = "Поле family должно быть заполнено";
        }


        if (isset($_POST['address'])) {
            $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
            if (empty($address)){
                $errors['address'] = "Поле Адресс не должно быть пустым";
            } elseif (strlen($address) < 3 || strlen($address) > 60) {
                $errors['address'] = "Адресс должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $address)) {
                $errors['address'] = "Адресс может содержать только буквы и цифры";
            }
        }else {
            $errors ['address'] = "Поле family должно быть заполнено";
        }


        if (isset($_POST['city'])) {
            $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
            if (empty($city)){
                $errors['city'] = "Поле Город не должно быть пустым";
            } elseif (strlen($city) < 3 || strlen($city) > 20) {
                $errors['city'] = "Поле Город должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я -]+$/u", $city)) {
                $errors['city'] = "Поле Город может содержать только буквы и цифры";
            }
        }else {
            $errors ['city'] = "Поле должно быть заполнено";
        }


        if (isset($_POST['phone'])) {
            $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
            if (empty($phone)){
                $errors['phone'] = "Номер телефона не должен быть пустым";
            } elseif (!preg_match("/^[0-9]+$/u", $phone)) {
                $errors['phone'] = "Номер телефона может содержать только цифры";
            } elseif (strlen($phone) < 3 || strlen($phone) > 15) {
                $errors['phone'] = "Номер телефона должен содержать не меньше 3 символов и не больше 15 символов";
            }
        }else {
            $errors ['phone'] = "Поле Почтовый индекс должно быть заполнено";
        }


        return $errors;
    }
}