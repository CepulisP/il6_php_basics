<?php

namespace Model;

use Helper\DBHelper;

class Type
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
        $type = $db->select()->from('types')->where('id', $id)->getOne();
        $this->id = $type['id'];
        $this->name = $type['name'];
        return $this;
    }

    public static function getCities()
    {
        $db = new DBHelper();
        $data = $db->select()->from('types')->get();
        $types = [];

        foreach ($data as $element) {
            $type = new City();
            $type->load($element['id']);
            $types[] = $type;
        }

        return $types;
    }
}