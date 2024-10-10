<?php
class User
{
    public function createUser(string $name, string $email, string $hash)
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
    }

    public function getByLogin(string $login): string|false
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :login');
        $stmt->execute(['login' => $login]);

        $data = $stmt->fetch();
        return $data;
    }
}