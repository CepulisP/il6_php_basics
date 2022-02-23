<?php

namespace Model;

use Helper\DBHelper;

class City
{
    private $id;

    private $name;

    protected const TABLE = 'cities';

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
        $city = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $city['id'];
        $this->name = $city['name'];
        return $this;
    }

    public static function getCities()
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $cities = [];

        foreach ($data as $element) {
            $city = new City();
            $city->load($element['id']);
            $cities[] = $city;
        }

        return $cities;
    }
}