<?php
namespace Controller;
use Model\UserProduct;
use Model\Product;

class ProductController
{
    private Product $product;
    private UserProduct $userProduct;

    public function __construct()
    {
        $this->product = new Product();
        $this->userProduct = new UserProduct();
    }

    public function getCatalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $catalog = $this->product->getProducts();

        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else{
            require_once "./../View/add_product.php";
        }
    }
    public function addProductToCart()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $errors = $this->validateProduct();

        if (empty($errors)) {
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $isProductInCart = $this->userProduct->getByUserIdAndProductId($userId, $productId); //есть ли продукт в козрине или нет
            if ($isProductInCart === false) {
                $this->userProduct->addProductToCart($userId, $productId, $amount); // Добавляем товар
                header('Location: /cart');
                exit;
            } else {
                $newAmount = $amount + $isProductInCart['amount'];
                $this->userProduct->plusProductAmountInCart($userId, $productId, $newAmount);
                header('Location: /cart');
                exit;
            }

        }

        require_once "./../View/add_product.php";
    }

    private function validateProduct(): array
    {
        $errors = [];

        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            $isCorrectIdProduct = $this->product->getByProductId($productId);  //есть ли такой товар к продуктах

            if (empty($productId)) {
                $errors['product'] = "ID товара не должно быть пустым";
            } elseif (!ctype_digit($productId)) {
                $errors['product'] = "Поле ID товара должно содержать только цифры!";
            } elseif ($productId <= 0) {
                $errors['product'] = "Поле ID товара не должно содержать отрицательные значения";
            } elseif ($isCorrectIdProduct === false) {
                $errors['product'] = "Введите корректный ID товара";
            }
        } else {
            $errors['product'] = 'Выберите продукт';
        }

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
            if (empty($amount)) {
                $errors['amount'] = "Выберите количество товара";
            } elseif (!ctype_digit($amount)) {
                $errors['amount'] = "Поле количества товара должно содержать только цифры!";
            } elseif ($amount <= 0) {
                $errors['amount'] = "Количество товара не должно быть отрицательным";
            }
        } else {
            $errors['amount'] = 'Выберите количество товара';
        }

        return $errors;
    }
}