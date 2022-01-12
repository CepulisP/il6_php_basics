<?php

const EMAIL_FIELD_KEY = 0;

function debug($data){
    echo '<pre>';
    var_dump($data);
    die();
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

function cleanEmail($email){
    return trim(strtolower($email));
}

function isEmailValid($email){
    return strpos($email, '@') !== false;
}

function isValueUniq($value, $key, $fileName){
    $users = readFromCsv($fileName);
    foreach ($users as $user){
        if ($user[$key] === $value){
            return false;
        }
    }
    return true;
}
