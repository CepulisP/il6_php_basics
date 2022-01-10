<?php

include 'helper.php';

$email = $_POST['email'];
$password = $_POST['password'];

$email = cleanEmail($email);
$password = hashPassword($password);

$users = readFromCsv('users.csv');

$login = false;

foreach ($users as $user){
    if ($password === $user[PASSWORD_FIELD_KEY] && $email === $user[EMAIL_FIELD_KEY]){
        $login = true;
        break;
    }
}

if($login){
    echo 'Hello';
}else{
    echo 'Fail';
}
