<?php
namespace Core;
use PDO;

class Model
{
    private static PDO $pdo;

    public static function getPdo(): PDO
    {
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');
        }
        return self::$pdo;
    }
}