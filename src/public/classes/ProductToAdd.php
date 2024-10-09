<?php
class ProductToAdd
{
    public function addProductToCart()
    {
        $errors = $this->validateProduct();

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

            $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :product_id');
            $stmt->execute(['product_id' => $productId]);
            $isCorrectIdProduct = $stmt->fetch(); //есть ли такой товар к продуктах

            if ($isCorrectIdProduct === false) {
                $errors['product'] = "Введите корректный ID товара";
            } else {
                $stmt = $pdo->prepare('SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id');
                $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
                $isProductInCart = $stmt->fetch(); //есть ли продукт в козрине или нет

                if ($isProductInCart === false) {
                    $this->addProduct($userId, $productId, $amount); // Добавляем товар
                } else {
                    $newAmount = $amount + $isProductInCart['amount'];
                    $this->plusAmount($userId, $productId, $newAmount);
                }
            }
            return $errors;
        } else{
            return $errors;
        }
    }

    private function addProduct($user, $product, $amount) {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user, 'product_id' => $product, 'amount' => $amount]);
        header('Location: /cart');
        exit;
    }

    private function plusAmount($user, $product, $amount) {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $user, 'product_id' => $product]);
        header('Location: /cart');
        exit;
    }

    private function validateProduct(): array
    {
        $errors = [];

        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];

            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :product_id');
            $stmt->execute(['product_id' => $productId]);
            $isCorrectIdProduct = $stmt->fetch(); //есть ли такой товар к продуктах

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
?>