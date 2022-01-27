<?php

namespace Model;

use Helper\DBHelper;

class User
{
    public static function emailUniq($email)
    {
        $db = new DBHelper();
        $db->select()->from('user')->where('email', $email)->get();
        return empty($rez);
    }

    public function delete($id)
    {
        $db = new DBHelper();
        $db->delete()->from('user')->where('id', $id)->exec();
    }
}