<?php
namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private int $price;
    private string|null $description;
    private string|null $image;

    public static function getByProductId(int $productId): self|null
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM products WHERE id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        $data = $stmt->fetch();
        if (empty($data)) {
            return null;
        }
        return self::hydrate($data);
    }

    public static function getProducts()
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();

        $catalog = [];
        foreach ($products as $product) {
            $catalog[] = self::hydrate($product);
        }
        return $catalog;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function setImage(?string $image): Product
    {
        $this->image = $image;
        return $this;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImage(): string|null
    {
        return $this->image;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }


    private static function hydrate(array $data): self|null
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->price = $data['price'];
        $obj->description = $data['description'];
        $obj->image = $data['image'];
        return $obj;
    }
}