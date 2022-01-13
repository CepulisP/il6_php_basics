<?php

include 'formHelper.php';

$inputs = [
    [
        'type' => 'text',
        'name' => 'name',
        'placeholder' => 'Your name'
    ],
    [
        'type' => 'text',
        'name' => 'last_name',
        'placeholder' => 'Your last name'
    ],
    [
        'type' => 'password',
        'name' => 'password',
        'placeholder' => 'Password'
    ],
    [
        'type' => 'password',
        'name' => 'password2',
        'placeholder' => 'Password'
    ],
    [
        'type' => 'select',
        'name' => 'childrens_number',
        'options' => [0, 1, 2, 3, '4+']
    ],
    [
        'type' => 'submit',
        'value' => 'Register',
        'name' => 'submit'
    ],
    [
        'type' => 'textarea',
        'name' => 'textarea',
    ]
];

echo '<body style="background-color: rgba(19,19,20,255);">';
    echo '<h2 style="color:white;">Registration form</h2>';
    echo '<form action="registration.php" method="post">';
    foreach ($inputs as $input) {
        if ($input['type'] == 'select') {
            echo '<label for="' . $input['name'] . '" style="color:white;">' . $input['name'] . ':</label><br>';
            echo generateSelect($input) . '<br>';
        } elseif ($input['type'] == 'textarea') {
            echo generateTextArea($input) . '<br>';
        } else {
            echo generateInput($input) . '<br>';
        }
    }
echo '</body>';
