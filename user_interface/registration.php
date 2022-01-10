<?php

include 'helper.php';

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password1'];
$password2 = $_POST['password2'];

$email = clearEmail($email);

$users = readFromCsv('users.csv');

$register = isEmailUniq($email);

//

if (isset($_POST['agree_terms'])) {
    if ($register) {
        if (isPasswordValid($password, $password2) && isEmailValid($email)) {
            $nickname = getNickname($firstName, $lastName);
            foreach ($users as $user) {
                while ($nickname == $user[4]) {
                    $nickname = $nickname . rand(1, 9);
                }
            }
            $data = [];
            $password = hashPassword($password);
            $data[] = [$firstName, $lastName, $email, $password, $nickname];
            writeToCsv($data, 'users.csv');
        } else {
            echo 'Something is wrong';
        }
    } else {
        echo 'email not unique';
    }
}else{
    echo 'Please agree to terms';
}