<?php
namespace Database;
use PDO;

class Database
{
    private PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
    }

    public function getConnectPdo()
    {
        return $this->pdo;
    }
}