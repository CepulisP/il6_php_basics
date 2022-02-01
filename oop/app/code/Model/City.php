<?php

namespace Model;

use Helper\DBHelper;

class City
{
    private $id;

    private $city;

    public function getId()
    {
        return $this->id;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public static function formatArrayForSelect($data)
    {
        $array['name'] = 'city_id';
//        $array=['name' => 'city_id'];

        foreach ($data as $element) {
            $array['options'][$element['id']] = $element['name'];
//            $array['options']=[$element['id'] => $element['name']]; //broken
        }
//        echo '<pre>';
//        print_r($array);
//        die();

        return $array;
    }

    public static function getCities()
    {
        $db = new DBHelper();
        $rez = $db->select()->from('cities')->get();

        return $rez;
    }
}