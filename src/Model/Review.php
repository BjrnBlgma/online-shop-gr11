<?php
namespace Model;

class Review extends Model
{
    private int $id;
    private string $review;
    private int|float $rating;
    private Product $product;
    private User $user;
    private string $name;
    private string $date;

    public static function createReview(string $review, int|float $rating, int $product, User $userId)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO reviews (review, rating, product_id, user_id, name) VALUES (:review, :rating, :product_id, :user_id, :user_name)");
        $stmt->execute(['review'=>$review, 'rating'=>$rating, 'product_id' => $product,'user_id'=>$userId->getId(), 'user_name'=>$userId->getName()]);
    }

    public static function getByUserId(int $userId): self|null
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM reviews WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(['user_id'=>$userId]);
        $res = $stmt->fetch();
        if (empty($res)) {
            return null;
        }
        return self::hydrate($res);
    }

    public static function getByProductId(int $productId)
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
        $stmt->execute(['product_id'=>$productId]);
        $data = $stmt->fetchAll();

        $result = [];
        foreach ($data as $elem) {
            $result[] = self::hydrate($elem);
        }
        return $result;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function getRating(): float|int
    {
        return $this->rating;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    private static function hydrate(array $data):self
    {
        $obj = new self();
        $productFromDb = Product::getByProductId($data['product_id']);
        $userFromDb = User::getById($data['user_id']);
        $obj->id = $data['id'];
        $obj->review = $data['review'];
        $obj->rating = $data['rating'];
        $obj->product = $productFromDb;
        $obj->user = $userFromDb;
        $obj->name = $userFromDb->getName();
        $obj->date = $data['date'];
        return $obj;
    }
}