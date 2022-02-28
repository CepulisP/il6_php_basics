<?php

namespace Model;

use Core\AbstractController;
use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Manufacturer extends AbstractModel implements ModelInterface
{
    private $name;

    protected const TABLE = 'manufacturers';

    public function __construct($id = null)
    {
        if ($id !== null){
            $this->load($id);
        }
    }

    public function assignData(){}

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
            $manufacturer = new Manufacturer($element['id']);
            $manufacturers[] = $manufacturer;
        }

        return $manufacturers;
    }
}