<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Type extends AbstractModel implements ModelInterface
{
    private $name;

    protected const TABLE = 'types';

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

    public function load($id)
    {
        $db = new DBHelper();
        $type = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $type['id'];
        $this->name = $type['name'];
        return $this;
    }

    public static function getTypes()
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $types = [];

        foreach ($data as $element) {
            $type = new Type($element['id']);
            $types[] = $type;
        }

        return $types;
    }
}