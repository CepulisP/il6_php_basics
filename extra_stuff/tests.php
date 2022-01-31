<?php

$id = 18;
$table = 'users';
$data = [
    'name' => 'john',
    'last_name' => 'john',
    'email' => 'john',
    'password' => 'john',
    'phone' => 'john',
    'city_id' => 'john'
];

$line = '';
$line .= 'UPDATE '.$table.' SET ';
$i=0;
foreach ($data as $key => $element){
    $count = count($data);
    $i++;
    if ($i<$count) {
        $line .= $key . ' = "' . $element . '", ';
    }else{
        $line .= $key . ' = "' . $element . '"';
    }
}
$line .= ' WHERE id = '.$id;
echo $line;