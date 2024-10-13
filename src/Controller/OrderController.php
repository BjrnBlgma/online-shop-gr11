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
require_once "./../Model/User.php";
class OrderController
{
    private UserProduct $userProduct;
    private Order $order;
    private User $user;
    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->order = new Order();
        $this->user = new User();
    }

    public function getOrderForm()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else{
            $productsInCart = $this->userProduct->getByUserId($userId);
            $allSum=0;
            $countProducts = 0;
            foreach($productsInCart as $product){
                $sum = $product['product_price'] * $product['user_products_amount'];
                $allSum += $sum;
                $countProducts += 1 * $product['user_products_amount'];
            }
            $allSum .="$";
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
            /*$selection = $_POST['selection'];*/
            $address = $_POST['address'];
            $city = $_POST['city'];
            /*$region = $_POST['region'];
            $index = $_POST['index'];*/
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            $productsInCart = $this->userProduct->getByUserId($userId);
            //print_r($productsInCart);
            $allSum=0;
            $countProducts = 0;
            $res =[];
            foreach($productsInCart as $product){
                $sum = $product['product_price'] * $product['user_products_amount'];
                $allSum += $sum;
                $countProducts += 1 * $product['user_products_amount'];
                $this->order->createOrder($userId, $product['product_id'], $product['user_products_amount'], $name, $family, $city, $address, $phone, $email);

            }

            $this->userProduct->deleteProduct($userId); // Удаляем товар из корзины, п.ч. сделали заказ
            header('Location: /cart');

        }
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


        /*if (isset($_POST['selection'])) {
            $selection = $_POST['selection'];
            if (empty($selection)){
                $errors['selection'] = "Поле не должно быть пустым";
            }
        }else {
                $errors ['selection'] = "Поле должно быть заполнено";
        }*/


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


        /*if (isset($_POST['region'])) {
            $region = htmlspecialchars($_POST['region'], ENT_QUOTES, 'UTF-8');
            if (empty($region)){
                $errors['region'] = "Поле Регион не должно быть пустым";
            } elseif (strlen($region) < 3 || strlen($region) > 60) {
                $errors['region'] = "Поле Регион должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $region)) {
                $errors['region'] = "Поле Регион может содержать только буквы и цифры";
            }
        }else {
            $errors ['region'] = "Поле family должно быть заполнено";
        }


        if (isset($_POST['index'])) {
            $index = htmlspecialchars($_POST['index'], ENT_QUOTES, 'UTF-8');
            if (empty($index)){
                $errors['index'] = "Почтовый индекс не должен быть пустым";
            } elseif (!preg_match("/^\d{6}$/", $index)) {
                $errors['index'] = "Почтовый индекс может содержать только цифры";
            }
        }else {
            $errors ['index'] = "Поле Почтовый индекс должно быть заполнено";
        }*/


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


        if (isset($_POST['email'])) {
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

            //$isCorrectEmail = $this->user->getByEmail($email); //свободна ли почта или уже занята
            if (empty($email)) {
                $errors ['email'] = "Почта не должна быть пустой";
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors ['email'] = "Введите корректный email-адрес!";
            }elseif ( (strlen($email) < 3)||(strlen($email) > 60) ){
                $errors ['email'] = "email-адрес должен содержать не меньше 3 символов и не больше 60 символов";
            }/*elseif ($isCorrectEmail['email'] === $email) {
                $errors['email'] = "Повторите email!";
            }*/
        }else{
            $errors ['email'] = "Поле email должно быть заполнено";
        }



        return $errors;
    }
}