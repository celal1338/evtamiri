<?php

declare(strict_types=1);

final class Database
{
    private static ?\PDO $connection = null;

    public static function connection(): \PDO
    {
        if (self::$connection instanceof \PDO) {
            return self::$connection;
        }

        $config = require __DIR__ . '/../config/database.php';

        $pdo = new \PDO($config['dsn'], $config['username'], $config['password']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        self::$connection = $pdo;

        return self::$connection;
    }
}
