<?php

declare(strict_types=1);

namespace Helper;

use Helper\Logger;

class DBHelper
{
    private \PDO $conn;

    private string $sql;

    public function __construct()
    {
        $this->sql = '';

        try {
            $this->conn = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            Logger::log("Connection failed: " . $e->getMessage());
        }
    }

    public function select(string $fields = '*'): DBHelper
    {
        $this->sql .= 'SELECT ' . $fields . ' ';
        return $this;
    }

    public function from(string $table): DBHelper
    {
        $this->sql .= ' FROM ' . $table;
        return $this;
    }

    public function where(string $field, $value, string $operator = '='): DBHelper
    {
        $this->sql .= ' WHERE ' . $field . ' ' . $operator . ' ' . '"' . $value . '"';
        return $this;
    }

    public function andWhere(string $field, $value, string $operator = '='): DBHelper
    {
        $this->sql .= ' AND ' . $field . ' ' . $operator . ' "' . $value . '"';
        return $this;
    }

    public function orWhere(string $field, $value, string $operator = '='): DBHelper
    {
        $this->sql .= ' OR ' . $field . ' ' . $operator . ' "' . $value . '"';
        return $this;
    }

    public function delete(): DBHelper
    {
        $this->sql .= ' DELETE ';
        return $this;
    }

    public function get(): ?array
    {
        $rez = $this->exec();
        return $rez->fetchAll();
    }

    public function exec(): ?\PDOStatement
    {
        if (DEBUG_MODE){
            Logger::log($this->sql);
        }
        return $this->conn->query($this->sql);
    }

    public function getOne(): array
    {
        $rez = $this->exec();
        $data = $rez->fetchAll();
        if (!empty($data)) {
            return $data[0];
        } else {
            return [];
        }
    }

    public function insert(string $table, array $data): DBHelper
    {
        $this->sql .= 'INSERT INTO ' . $table
            . ' (' . implode(',', array_keys($data))
            . ') VALUES ("' . implode('","', $data) . '")';
        return $this;
    }

    public function update(string $table, array $data): DBHelper
    {
        $this->sql .= 'UPDATE ' . $table . ' SET ';
        $values = [];

        foreach ($data as $column => $value) {
            $values[] = "$column = '$value'";
        }

        $this->sql .= implode(',', $values);

        return $this;
    }

    public function limit(int $number): DBHelper
    {
        $this->sql .= ' LIMIT ' . $number;
        return $this;
    }

    public function offset(int $number): DBHelper
    {
        $this->sql .= ' OFFSET ' . $number;
        return $this;
    }

    public function orderby(string $field, string $order): DBHelper
    {
        $this->sql .= ' ORDER BY ' . $field . ' ' . $order;
        return $this;
    }
}