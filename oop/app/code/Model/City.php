<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class City extends AbstractModel
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
        $city = $db->select()->from('cities')->where('id', $id)->getOne();
        $this->id = $city['id'];
        $this->name = $city['name'];
        return $this;
    }

    public static function getCities()
    {
        $db = new DBHelper();
        $data = $db->select()->from('cities')->get();
        $cities = [];

        foreach ($data as $element) {
            $city = new City();
            $city->load($element['id']);
            $cities[] = $city;
        }

        return $cities;
    }
}