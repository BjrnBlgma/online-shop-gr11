<?php
class ProductController
{
    public function getCatalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        require_once "./../Model/Product.php";
        $prod = new Product();
        $catalog = $prod->getProductsForCatalog();

        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        require_once "./../View/add_product.php";
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

            require_once "./../Model/UserProduct.php"; //есть ли продукт в козрине или нет
            $userProducts = new UserProduct();
            $isProductInCart = $userProducts->getByUserIdAndProductId($userId, $productId);

            if ($isProductInCart === false) {
                $this->addProduct($userId, $productId, $amount); // Добавляем товар
            } else {
                $newAmount = $amount + $isProductInCart['amount'];
                $this->plusAmount($userId, $productId, $newAmount);
            }
        }

        require_once "./../View/add_product.php";
    }


    private function addProduct($user, $product, $amount) {
        require_once "./../Model/UserProduct.php";
        $userProducts = new UserProduct();
        $userProducts->addProductToCart($user, $product, $amount);
        header('Location: /cart');
        exit;
    }

    private function plusAmount($user, $product, $amount) {
        require_once "./../Model/UserProduct.php";
        $userProducts = new UserProduct();
        $userProducts->plusProductAmountInCart($user, $product, $amount);
        header('Location: /cart');
        exit;
    }


    private function validateProduct(): array
    {
        $errors = [];

        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            require_once "./../Model/Product.php";
            $product =  new Product();
            $isCorrectIdProduct = $product->getByProductId($productId);  //есть ли такой товар к продуктах
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