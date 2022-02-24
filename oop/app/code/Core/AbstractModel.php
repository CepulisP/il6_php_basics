<?php

namespace Core;

use Helper\DBHelper;

class AbstractModel
{
    protected $data;

    protected $id;

    protected const TABLE = '';

    public function getId()
    {
        return $this->id;
    }

    public function save()
    {
        $this->assignData();
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    protected function update()
    {
        $db = new DBHelper();
        $db->update(static::TABLE, $this->data)->where('id', $this->id)->exec();
    }

    protected function create()
    {
        $db = new DBHelper();
        $db->insert(static::TABLE, $this->data)->exec();
    }

    protected function assignData()
    {
        $this->data = [];
    }

    public function delete()
    {
        $db = new DBHelper();
        $db->delete()->from(static::TABLE)->where('id', $this->id)->exec();
    }

    public static function isValueUniq($field, $value)
    {
        $value = strtolower(trim($value));
        $db = new DBHelper();
        $rez = $db->select()->from(static::TABLE)->where($field, $value)->get();
        return empty($rez);
    }

    public static function count($activeOnly = true)
    {
        $db = new DBHelper();
        $db->select('count(*)')->from(static::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }
        $rez = $db->get();

        return $rez[0][0];
    }
}