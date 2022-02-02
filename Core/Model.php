<?php

namespace Core;

use PDO;

class Model
{
    static protected string $tableName = '';

    use DataBaseTrait;

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tableName;
        return static::db()->query($query)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function find(int $id)
    {
        $query = 'SELECT * FROM ' . static::$tableName . ' WHERE id = :id';

        $stmt = static::db()->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject(static::class);
    }

    public static function create(array $data)
    {
        $vars = static::preparedQueryVars($data);

        $query = "INSERT INTO " . static::$tableName . ' (' . $vars['keys'] . ') VALUES (' . $vars['placeholders'] . ')';
        $stmt = static::db()->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        $stmt->execute();

        return (int)static::db()->lastInsertId();
    }

    public function update(array $data)
    {
        $vars = static::preparedQueryVars($data);

        $query = "UPDATE " . static::$tableName . ' SET ';

        $ps = [];
        foreach ($data as $key => $value) {
            $ps[] = " {$key}=:{$key}";
        }
        $query .=  implode(', ', $ps);

        $query .= " WHERE id=:id";

        $stmt = static::db()->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        $stmt->bindValue('id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return static::find($this->id);
    }


    protected static function preparedQueryVars($data): array
    {
        $placeholders = [];

        foreach ($data as $key => $values) {
            $placeholders[] = ":{$key}";
        }

        return [
          'keys' => implode(', ', array_keys($data)),
          'placeholders' => implode(', ', array_values($placeholders))
        ];
    }
}