<?php
class UserProduct
{
    public function getByUserIdAndProductId(int $userId, int $productId)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare('SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $isProductInCart = $stmt->fetch();

        return $isProductInCart;
    }

    public function addProductToCart(int $user, int $product, int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user, 'product_id' => $product, 'amount' => $amount]);
    }

    public function plusProductAmountInCart(int $user, int $product, int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user, 'product_id' => $product, 'amount' => $amount]);
    }

    public function getByUserId($user)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("SELECT 
            products.name as product_name, 
            products.image as product_image, 
            products.price as product_price, 
            user_products.amount as user_products_amount 
            FROM user_products INNER JOIN products ON products.id = user_products.product_id  WHERE user_id = :user_id
            ");
        $stmt->execute(['user_id' => $user]);

        $userID = $stmt->fetchAll();
        return $userID;
    }
}