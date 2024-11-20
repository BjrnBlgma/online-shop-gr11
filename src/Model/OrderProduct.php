<?php
namespace Ariana\FirstProject\Model;
use Core\Model;

class OrderProduct extends Model
{
    private int $id;
    private Order $order;
    private Product $product;
    private int $amount;
    private int|float $price;

    public static function sendProductToOrder(int $orderId, Product $product, int $amount): void
    {
        $stmt = self::getPdo()->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $product->getId(), 'amount' => $amount, 'price'=> $product->getPrice()]);
    }

    public static function getByUserIdandProductId(int $userId, int $productId)
    {
        $stmt = self::getPdo()->prepare("SELECT
            orders.id as order_id, 
            orders.name as order_name, 
            orders.user_id as orders_user_id,
            order_products.id as order_products_id,
            order_products.product_id as order_products_product_id,
            order_products.amount as order_products_amount,
            order_products.price as order_products_price
            FROM order_products 
                INNER JOIN orders ON orders.id = order_products.order_id
            WHERE orders.user_id = :user_id and order_products.product_id = :product_id
            ");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);

        $data = $stmt->fetchAll();
        $result = [];
        foreach ($data as $elem) {
            $result[] = self::hydrateWithJoin($elem);
        }
        return $result;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPrice(): float|int
    {
        return $this->price;
    }

    private static function hydrateWithJoin(array $elem)
    {
        $order = new Order();
        $order->setId($elem['order_id']);
        $order->setName($elem['order_name']);
        $order->setUserId($elem['orders_user_id']);

        $product = new Product();
        $product->setId($elem['order_products_product_id']);

        $obj = new self();
        $obj->id = $elem['order_products_id'];
        $obj->order = $order;
        $obj->product = $product;
        $obj->amount = $elem['order_products_amount'];
        $obj->price = $elem['order_products_price'];
        return $obj;
    }
}