<?php

function debug($data)
{
    echo '<pre>';
    var_dump($data);
    die();
}

function generateInput($data)
{
    $input = '';
    $input .= '<input ';
    foreach ($data as $key => $value) {
        $input .= $key . '="' . $value . '" ';
    }
    $input .= '>';
    return $input;
}

function generateSelect($data)
{
    $input = '';
    $input .= '<select name="' . $data['name'] . '" id="' . $data['name'] . '"><br><option value=" "></option><br>';
    foreach ($data['options'] as $value) {
        $input .= '<option value="' . $value . '">' . $value . '</option><br>';
    }
    $input .= '</select>';
    return $input;
}

function generateTextArea($data){
    $input = '';
    $input .= '<'.$data['type'].' name="'.$data['name'].'"></textarea>';
    return $input;
}
