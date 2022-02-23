<?php

namespace Model;

use Helper\DBHelper;

class Manufacturer
{
    private $id;

    private $name;

    protected const TABLE = 'manufacturers';

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $manufacturer = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $manufacturer['id'];
        $this->name = $manufacturer['name'];
        return $this;
    }

    public static function getManufacturers()
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $manufacturers = [];

        foreach ($data as $element) {
            $manufacturer = new Manufacturer();
            $manufacturer->load($element['id']);
            $manufacturers[] = $manufacturer;
        }

        return $manufacturers;
    }
}