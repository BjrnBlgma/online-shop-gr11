<?php
namespace Ariana\FirstProject\Model;
use Core\Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;


    public static function createUser(string $name, string $email, string $hash)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
    }

    public static function getByEmail(string $login): self|null
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $login]);

        $data = $stmt->fetch();

        if (empty($data)){
            return null;
        }
        return self::hydrate($data);
    }

    public static function getById(int $id): self|null
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch();

        if (empty($data)){
            return null;
        }
        return self::hydrate($data);
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }



    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    private static function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];
        return $obj;
    }
}