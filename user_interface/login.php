<?php

include 'helper.php';

$email = $_POST['email'];
$password = $_POST['password'];

$email = clearEmail($email);
$password = hashPassword($password);

$users = readFromCsv('users.csv');

$login = false;

foreach ($users as $user){
    if ($password === $user[3] && $email === $user[2]){
        $login = true;
        break;
    }
}

if($login){
    echo 'Hello';
}else{
    echo 'Fail';
}
