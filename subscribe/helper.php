<?php

function debug($data){
    echo '<pre>';
    var_dump($data);
    die();
}

function writeToCsv($data, $fileName){
    $file = fopen($fileName, 'a');
    fputcsv($file, [$data]);
    fclose($file);
}

function cleanString($string){
    return trim(strtolower($string));
}

function isEmailValid($email){
    return strpos($email, '@') !== false;
}

function isValueUniq($value, $fileName){
    $users = file($fileName);
    foreach ($users as $user){
        if (cleanString($user) === $value){
            return false;
        }
    }
    return true;
}
