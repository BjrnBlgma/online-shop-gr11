<?php
/* 1. создать таблицу для заказа, у которой будут следующие колонки:
id заказа;
id пользователя;
данные(имя продукта, количество) из таблицы юзер_продуктс, при котором эти данные будут удалятся после оформления заказа
данные из формы заказа (имя, фамилия, почта, номер телефона, адресс и тд)
 * ✓✓✓  2. переделать форму регистрации, убрать ненужное  ✓✓✓
 * 3. сделать handle_order(OrderController.php), при котором после оформления заказа или открывается страница "Спасибо за заказ!",
либо открывается запись в пустой  "Спасибо за заказ!"
 * 4. после создания таблицы заказа в бд и создания кода, чтобы сделать передачу данных в таблицу заказа и удаления похожих данных из таблицы корзины
 *    создать файл "Спасибо за заказ!", который будет открываться в корзине, куда будет переносить код после оформления заказа
 * 5. Сделать кнопку в корзине "Оформить заказ", которая будет переносить на OrderController, в одном из кодов которых будет открываться product_order.php
 *
 */
require_once "./../Model/UserProduct.php";
require_once "./../Model/Order.php";
class OrderController
{
    private UserProduct $userProduct;
    private Order $order;
    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->order = new Order();
    }

    public function getOrderForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else{
            require_once "./../View/product_order.php";
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
            $name = $_POST['name'];
            $email = $_POST['email'];
            $family = $_POST['family'];

            $this->order->createOrder($userId, $name, $family, $email); //добавить переменные для добавления информации в табицу Order
            $isProductInOrder = $this->order->getByUserIdAndProductId($userId, $productId); //есть ли продукт в заказе или нет
            if ($isProductInOrder) {
                $this->userProduct->deleteProduct($userId, $productId); // Удаляем товар из корзины, п.ч. сделали заказ
                header('Location: /cart');
                exit;
            }



        }
        require_once "./../View/product_order.php";
    }

    private function validateOrder(): array //переделать валидацию, после создания таблицы в бд
    {
        $errors = [];

        if (isset($_POST['name'])) {
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            if (empty($name)){
                $errors['name'] = "Имя не должно быть пустым";
            } elseif (strlen($name) < 3 || strlen($name) > 20) {
                $errors['name'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors['name'] = "Имя может содержать только буквы";
            }
        }else{
            $errors ['name'] = "Поле name должно быть заполнено";
        }


        if (isset($_POST['email'])) {
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

            $isCorrectEmail = $this->user->getByEmail($email); //свободна ли почта или уже занята
            if (empty($email)) {
                $errors ['email'] = "Почта не должна быть пустой";
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors ['email'] = "Введите корректный email-адрес!";
            }elseif ( (strlen($email) < 3)||(strlen($email) > 60) ){
                $errors ['email'] = "email-адрес должен содержать не меньше 3 символов и не больше 60 символов";
            }elseif ($isCorrectEmail) {
                $errors['email'] = "email уже занят!";
            }
        }else{
            $errors ['email'] = "Поле email должно быть заполнено";
        }


        if (isset($_POST['password'])) {
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
            if (empty($password)) {
                $errors ['password'] = "Пароль не должен быть пустым";
            }elseif (strlen($password) < 8 || strlen($password) > 20) {
                $errors ['password'] = "Пароль должен быть не менее 8 символов и не более 20 символов";
            }
        }else{
            $errors ['password'] = "Поле password должно быть заполнено";
        }


        if (isset($_POST['psw-repeat'])) {
            $passRepeat = htmlspecialchars($_POST['psw-repeat'], ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'];
            if (empty($passRepeat)) {
                $errors ['psw-repeat'] = "Поле не должно быть пустым";
            }elseif ($passRepeat != $password) {
                $errors ['psw-repeat'] = "Пароли не совпадают"; //Passwords do not match"
            }
        }else {
            $errors ['psw-repeat'] = "Поле repeat password должно быть заполнено";
        }

        return $errors;
    }
}