<?php

namespace Model;

use Helper\DBHelper;

class Model
{
    private $id;

    private $name;

    private $manufacturerId;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $model = $db->select()->from('models')->where('id', $id)->getOne();
        $this->id = $model['id'];
        $this->name = $model['name'];
        $this->manufacturerId = $model['manufacturer_id'];
        return $this;
    }

    public static function getCities()
    {
        $db = new DBHelper();
        $data = $db->select()->from('models')->get();
        $models = [];

        foreach ($data as $element) {
            $model = new City();
            $model->load($element['id']);
            $models[] = $model;
        }

        return $models;
    }
}