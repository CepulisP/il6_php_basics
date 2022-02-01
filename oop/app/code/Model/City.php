<?php

namespace Model;

use Helper\DBHelper;

class City
{
    public static function getCities()
    {
        $db = new DBHelper();
        $rez = $db->select('*')->from('cities')->get();

        return $rez;
    }
}