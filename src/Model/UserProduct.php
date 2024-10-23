<?php
namespace Model;

class UserProduct extends Model
{
    private int $id;
    private User $user;
    private Product $product;
    private int $amount;


     public function getByUserIdAndProductId(int $userId, int $productId): self|null
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $isProductInCart = $stmt->fetch();

        if (empty($isProductInCart)) {
            return null;
        }
        return $this->hydrate($isProductInCart);
    }

    public function addProductToCart(int $user, int $product, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user, 'product_id' => $product, 'amount' => $amount]);
    }

    public function plusProductAmountInCart(int $user, int $product, int $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user, 'product_id' => $product, 'amount' => $amount]);
    }

    public function getByUserIdWithJoin(int $user)
    {
        $stmt = $this->pdo->prepare("SELECT *
            FROM user_products
                INNER JOIN products ON products.id = user_products.product_id
                INNER JOIN users ON users.id = user_products.user_id
            WHERE user_id = :user_id
            ");
        $stmt->execute(['user_id' => $user]);
        $data = $stmt->fetchAll();

        $result = [];
        foreach ($data as $elem) {
            $result[] = $this->hydrateWithJoin($elem);
        }
        return $result;
    }

    public function getByUserIdWithoutJoin(int $user)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user]);
        $data = $stmt->fetchAll();

        $result = [];
        foreach ($data as $elem) {
            $result[] = $this->hydrate($elem);
        }
        return $result;
    }

    public function deleteProduct(int $user)
    {
        $stmt = $this->pdo->prepare( "DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserProduct
    {
        $this->id = $id;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): UserProduct
    {
        $this->user = $user;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): UserProduct
    {
        $this->product = $product;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): UserProduct
    {
        $this->amount = $amount;
        return $this;
    }


    private function hydrate(array $data)
    {
        $object = new self();

        $user = new User();
        $userFromDb = $user->getById($data['user_id']);

        $product = new Product();
        $productFromDb = $product->getByProductId($data['product_id']);


        $object->id = $data['id'];
        $object->user = $userFromDb;
        $object->product = $productFromDb;
        $object->amount = $data['amount'];

        return $object;
    }

    private function hydrateWithJoin(array $data)
    {
        $user = new User();
        $user->setId($data['user_id']);
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        $product = new Product();
        $product->setId($data['product_id']);
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setImage($data['image']);
        $product->setDescription($data['description']);

        $obj = new self();
        $obj->id = $data['id'];
        $obj->user = $user;
        $obj->product = $product;
        $obj->amount = $data['amount'];

        return $obj;
    }
}