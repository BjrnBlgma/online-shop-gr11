<?php
namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private int $price;
    private string|null $description;
    private string|null $image;

    public function getByProductId(int $productId): self|null
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        $data = $stmt->fetch();
        if (empty($data)) {
            return null;
        }
        return $this->hydrate($data);
    }

    public function getProducts()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();

        $catalog = [];
        foreach ($products as $product) {
            $catalog[] = $this->hydrate($product);
        }
        return $catalog;
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


    private function hydrate(array $data)
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