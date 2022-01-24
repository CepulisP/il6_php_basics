<?php

include 'FormHelper.php';

$data = [
    'type' => 'text',
    'name' => 'name',
    'placeholder' => 'Name'
];
$data2 = [
    'type' => 'text',
    'name' => 'last_name',
    'placeholder' => 'Last Name'
];
$data3 = [
    'type' => 'email',
    'name' => 'email',
    'placeholder' => 'name@mail.com'
];
$data4 = [
    'type' => 'password',
    'name' => 'password',
    'placeholder' => 'Password'
];

$formLogin = new FormHelper('login.php', 'POST');
$formRegister = new FormHelper('register.php', 'POST');

$formRegister->input($data);
$formRegister->input($data2);
$formRegister->input($data3);
$formRegister->input($data4);
$formRegister->textArea('comment');

$formLogin->input($data3);
$formLogin->input($data4);

echo $formLogin->getForm();
echo '<br>';
echo $formRegister->getForm();