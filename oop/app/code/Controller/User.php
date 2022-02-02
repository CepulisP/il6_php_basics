<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Validator;
use Model\User as UserModel;
use Model\City;
use Helper\Url;

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
        $cities = City::getCities();

        $form->input(['name' => 'name', 'type' => 'text', 'placeholder' => 'Name']);
        $form->input(['name' => 'last_name', 'type' => 'text', 'placeholder' => 'Last name']);
        $form->input(['name' => 'phone', 'type' => 'text', 'placeholder' => 'Phone (+370...)']);
        $form->input(['name' => 'email', 'type' => 'email', 'placeholder' => 'name@mail.com']);
        $form->input(['name' => 'password', 'type' => 'password', 'placeholder' => 'Password']);
        $form->input(['name' => 'password2', 'type' => 'password', 'placeholder' => 'Repeat password']);

//        Array need to be in this format for select to work properly
//
//        $example = [
//            'name' => 'city_id',
//            'options'=>[
//                '1' => 'vilnius',
//                '2' => 'kaunas'
//            ]
//        ];

        $options = [];

        foreach ($cities as $city) {
            $options[$city->getId()] = $city->getName();
        }

        $form->select(['name' => 'city_id', 'options' => $options]);
        $form->input(['name' => 'create', 'type' => 'submit', 'value' => 'Register']);

        echo $form->getForm();
    }

    public function edit()
    {
        $form = new FormHelper('user/update/', 'POST');
        $user = new UserModel();
        $cities = City::getCities();

        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Name',
            'value' => $user->load($_SESSION['user_id'])->getName()
        ]);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Last name',
            'value' => $user->load($_SESSION['user_id'])->getLastName()
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => 'Phone (+370...)',
            'value' => $user->load($_SESSION['user_id'])->getPhone()
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'name@mail.com',
            'value' => $user->load($_SESSION['user_id'])->getEmail()
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'edit',
            'type' => 'submit',
            'value' => 'Save'
        ]);

        echo $form->getForm();
    }

    public function login()
    {
        $form = new FormHelper('user/check/', 'POST');

        $form->input(['name' => 'email', 'type' => 'email', 'placeholder' => 'name@mail.com']);
        $form->input(['name' => 'password', 'type' => 'password', 'placeholder' => 'Password']);
        $form->input(['name' => 'login', 'type' => 'submit', 'value' => 'Login']);

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
            $user->save();
            Url::redirect('user/login');

        } else {
            echo 'Check email and password';
        }
    }

    public function update()
    {
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUniq = UserModel::emailUniq($_POST['email']);

        if ($isEmailValid && $isEmailUniq) {

            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setEmail($_POST['email']);
            $user->setPhone($_POST['phone']);
            $user->setPassword(md5($_POST['password']));
            $user->setCityId($_POST['city_id']);
            $user->save();
            Url::redirect('');

        } else {
            echo 'Email not unique or invalid';
        }
    }

    public function check()
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $userId = UserModel::checkLoginCredentials($email, $password);

        if ($userId) {
            $user = new UserModel();
            $user->load($userId);

            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['user'] = $user;

            Url::redirect('');

            echo '<h2 style="text-align:center;">Welcome!</h2>';
        } else {
            Url::redirect('user/login');
            echo 'Check your credentials';
        }
    }

    public function logout()
    {
        session_destroy();
    }
}