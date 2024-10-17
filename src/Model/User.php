<?php
namespace Model;

class User extends Model
{
    public function createUser(string $name, string $email, string $hash)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
    }

    public function getByEmail(string $login)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $login]);

        $data = $stmt->fetch();
        return $data;
    }
}