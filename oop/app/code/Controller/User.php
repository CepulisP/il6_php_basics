<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Validator;
use Model\User as UserModel;

class User
{
    public function show($id = null)
    {
        if ($id !== null) {
            echo 'User controller ID ' . $id;
        } else {
            echo '404 no id';
        }
    }

    public function register()
    {
        $form = new FormHelper('user/create/', 'POST');

        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Name'
        ]);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Last name'
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => '+3706*******'
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'name@mail.com'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'Repeat password'
        ]);
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Register'
        ]);

        echo $form->getForm();
    }

    public function login()
    {
        $form = new FormHelper('user/check/', 'POST');
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'name@mail.com'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'login',
            'type' => 'submit',
            'value' => 'Login'
        ]);

        echo $form->getForm();
    }

    public function create()
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUniq = UserModel::emailUniq($_POST['email']);

        if ($passMatch && $isEmailValid && $isEmailUniq) {

            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setEmail($_POST['email']);
            $user->setPhone($_POST['phone']);
            $user->setPassword(md5($_POST['password']));
            $user->setCityId(1);
            $user->save();

            echo '<h2 style="text-align:center;">Welcome!</h2>';

        } else {
            echo 'Check email and password';
        }
    }

    public function update()
    {

    }
}