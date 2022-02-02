<?php

namespace Core;

use PDO;

trait DataBaseTrait
{
    /**
     * @var PDO|null
     */
    static protected PDO|null $connect = null;

    /**
     * @return PDO|null
     */
    public static function db(): PDO|null
    {
        if (is_null(static::$connect)) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            static::$connect = new PDO($dsn, DB_USER, DB_PASSWORD);
            static::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return static::$connect;
    }
}