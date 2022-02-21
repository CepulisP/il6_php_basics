<?php

namespace Helper;

use Helper\Logger;

class DBHelper
{
    private $conn;

    private $sql;

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

    public function select($fields = '*')
    {
        $this->sql .= 'SELECT ' . $fields . ' ';
        return $this;
    }

    public function from($table)
    {
        $this->sql .= ' FROM ' . $table;
        return $this;
    }

    public function where($field, $value, $operator = '=')
    {
        $this->sql .= ' WHERE ' . $field . ' ' . $operator . ' ' . '"' . $value . '"';
        return $this;
    }

    public function andWhere($field, $value, $operator = '=')
    {
        $this->sql .= ' AND ' . $field . ' ' . $operator . ' "' . $value . '"';
        Logger::log($operator.'<-this');
        return $this;
    }

    public function orWhere($field, $value, $operator = '=')
    {
        $this->sql .= ' OR ' . $field . ' ' . $operator . ' "' . $value . '"';
        return $this;
    }

    public function delete()
    {
        $this->sql .= ' DELETE ';
        return $this;
    }

    public function get()
    {
        $rez = $this->exec();
        return $rez->fetchAll();
    }

    public function exec()
    {
        if (DEBUG_MODE){
            Logger::log($this->sql);
        }
        return $this->conn->query($this->sql);
    }

    public function getOne()
    {
        $rez = $this->exec();
        $data = $rez->fetchAll();
        if (!empty($data)) {
            return $data[0];
        } else {
            return [];
        }
    }

    public function insert($table, $data)
    {
        $this->sql .= 'INSERT INTO ' . $table
            . ' (' . implode(',', array_keys($data))
            . ') VALUES ("' . implode('","', $data) . '")';
        return $this;
    }

    public function update($table, $data)
    {
        $this->sql .= 'UPDATE ' . $table . ' SET ';
        $values = [];

        foreach ($data as $column => $value) {
            $values[] = "$column = '$value'";
        }

        $this->sql .= implode(',', $values);

        return $this;
    }

    public function limit($number)
    {
        $this->sql .= ' LIMIT ' . $number;
        return $this;
    }

    public function offset($number)
    {
        $this->sql .= ' OFFSET ' . $number;
        return $this;
    }

    public function orderby($field, $order)
    {
        $this->sql .= ' ORDER BY ' . $field . ' ' . $order;
        return $this;
    }
}