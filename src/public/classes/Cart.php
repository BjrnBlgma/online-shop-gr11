<?php
class Cart
{
    public function lookCart(): array
    {
        $userId = $_SESSION['user_id'];

        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("SELECT products.name as product_name, products.image as product_image, products.price as product_price, user_products.amount as user_products_amount FROM user_products INNER JOIN products ON products.id = user_products.product_id  WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        $userProducts = $stmt->fetchAll();
        return $userProducts;
    }

    public function sumCart(): int
    {
        $allSum=0;
        $userProducts = $this->lookCart();
        foreach($userProducts as $product){
            $sum = $product['product_price'] * $product['user_products_amount'];
            $allSum += $sum;
        }
        return $allSum;
    }
}
?>