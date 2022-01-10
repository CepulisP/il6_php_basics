<?php

include 'helper.php';

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password1'];
$password2 = $_POST['password2'];

$email = cleanEmail($email);

$users = readFromCsv('users.csv');

if (isset($_POST['agree_terms'])) {
    if (isValueUniq($email, EMAIL_FIELD_KEY)) {
        if (isPasswordValid($password, $password2) && isEmailValid($email)) {
            $nickname = getNickname($firstName, $lastName);
            while (!isValueUniq($nickname, NICKNAME_FIELD_KEY)){
                $nickname = $nickname.rand(0,9);
            }
            $data = [];
            $password = hashPassword($password);
            $data[] = [$firstName, $lastName, $email, $password, $nickname];
            writeToCsv($data, 'users.csv');
        } else {
            echo 'Check email and password';
        }
    } else {
        echo 'email not unique';
    }
}else{
    echo 'Please agree to terms';
}
