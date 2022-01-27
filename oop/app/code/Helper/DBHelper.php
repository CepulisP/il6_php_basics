<?php

namespace Helper;

class DBHelper
{
    private $conn;
    private $sql;

    public function __construct()
    {
        $this->sql = '';

        try {
            $this->conn = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        } catch (PDOException $e) {
            //echo "Connection failed: " . $e->getMessage();
        }
    }

    public function select($fields = '*')
    {
        $this->sql .= 'SELECT ' . $fields . ' ';
        return $this;
    }

    public function from($table)
    {
        $this->sql .= ' FROM ' . $table . ' ';
        return $this;
    }

    public function where($field, $value, $operator = '=')
    {
        $this->sql .= ' WHERE ' . $field . $operator . '"' . $value . '"';
        return $this;
    }

    public function delete()
    {
        $this->sql .= ' DELETE ';
        return $this;
    }

    public function get()
    {
        $rez = $this->conn->query($this->sql);
        return $rez->fetchAll();
    }

    public function exec()
    {
        $this->conn->query($this->sql);
    }

    public function getOne()
    {
        $rez = $this->conn->query($this->sql);
        $data = $rez->fetchAll();
        return $data[0];
    }
}