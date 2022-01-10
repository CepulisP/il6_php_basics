<?php

const EMAIL_FIELD_KEY = 2;

const PASSWORD_FIELD_KEY = 3;

const NICKNAME_FIELD_KEY = 4;

const PRODUCT_ID_FIELD_KEY = 0;

const PRODUCT_NAME_FIELD_KEY = 1;

const PRODUCT_SKU_FIELD_KEY = 2;

const PRODUCT_QTY_FIELD_KEY = 3;

const PRODUCT_PRICE_FIELD_KEY = 4;

function cleanEmail($email){
    return trim(strtolower($email));
}

function isEmailValid($email){
    return strpos($email, '@') !== false;
}

function isValueUniq($value, $key){
    $users = readFromCsv('users.csv');
    foreach ($users as $user){
        if ($user[$key] === $value){
            return false;
        }
    }
    return true;
}

function isPasswordValid($pass1, $pass2){
    return $pass1 === $pass2 && strlen($pass1) > 8;
}

function hashPassword($password){
    return md5(md5($password).'druska');
}

function writeToCsv($data, $fileName){
    $file = fopen($fileName, 'a');
    foreach ($data as $element){
        fputcsv($file, $element);
    }
    fclose($file);
}

function readFromCsv($fileName){
    $data = [];
    $file = fopen($fileName, 'r');
    while(!feof($file)){
        $line = fgetcsv($file);
        if (!empty($line)){
            $data[] = $line;
        }
    }
    fclose($file);
    return $data;
}

function debug($data){
    echo '<pre>';
    var_dump($data);
    die();
}

function getNickname($name, $surName){
    return strtolower(substr($name, 0, 3).substr($surName, 0, 3));
}
