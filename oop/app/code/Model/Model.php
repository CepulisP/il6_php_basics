<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Model extends AbstractModel implements ModelInterface
{
    private $name;

    private $manufacturerId;

    protected const TABLE = 'models';

    public function __construct($id = null)
    {
        if ($id !== null){
            $this->load($id);
        }
    }

    public function assignData()
    {
        // TODO: Implement assignData() method.
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
        $model = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $model['id'];
        $this->name = $model['name'];
        $this->manufacturerId = $model['manufacturer_id'];
        return $this;
    }

    public static function getModels()
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $models = [];

        foreach ($data as $element) {
            $model = new Model($element['id']);
            $models[] = $model;
        }

        return $models;
    }

    public static function getModelsByManufacturer($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('manufacturer_id', $id)->get();
        $models = [];

        foreach ($data as $element) {
            $model = new Model($element['id']);
            $models[] = $model;
        }

        return $models;
    }
}