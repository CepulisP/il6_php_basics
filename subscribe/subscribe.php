<?php

include 'helper.php';

$email = cleanEmail($_POST['email']);

if (isEmailValid($email)){
    if (isValueUniq($email, EMAIL_FIELD_KEY, 'emails.csv')) {
        $data = [];
        $data[] = [$email];
        writeToCsv($data, 'emails.csv');
        echo 'Welcome';
    }else{
        echo 'Email taken';
    }
}else{
    echo 'Check your email';
}
