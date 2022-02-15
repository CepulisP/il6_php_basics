<?php

namespace Model;

use Helper\DBHelper;

class Manufacturer
{
    private $id;

    private $name;

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
        $manufacturer = $db->select()->from('manufacturers')->where('id', $id)->getOne();
        $this->id = $manufacturer['id'];
        $this->name = $manufacturer['name'];
        return $this;
    }

    public static function getmanufacturers()
    {
        $db = new DBHelper();
        $data = $db->select()->from('manufacturers')->get();
        $manufacturers = [];

        foreach ($data as $element) {
            $manufacturer = new City();
            $manufacturer->load($element['id']);
            $manufacturers[] = $manufacturer;
        }

        return $manufacturers;
    }
}