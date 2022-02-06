<?php

namespace Core;

use PDO;

class Model
{
    static protected string $tableName = '';

    static protected $query = "";

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

    public static function delete(int $id)
    {
        $query = 'DELETE FROM ' . static::$tableName . ' WHERE id = :id';

        $stmt = static::db()->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function select(array $keys = ['*']): Model
    {
        static::$query = "";
        static::$query = "SELECT " . implode(',', $keys) . " FROM " . static::$tableName . " ";

        return new static();
    }

    public function where(array $conditions)
    {
        $condition = $conditions[2];
        unset($conditions[2]);

        static::$query .=  'WHERE ' . implode(' ', $conditions) . ' :condition';

        $stmt = static::db()->prepare(static::$query);
        $stmt->bindValue(':condition', $condition);

        $stmt->execute();

        return $stmt->fetchObject(static::class);
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