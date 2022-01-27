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

        if ($id === 'you-got-clickbaited') {
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }

    public function register($id = null)
    {
        $form = new FormHelper('user/create/', 'POST');
        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Name'
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

        if ($id === 'you-got-clickbaited') {
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;">YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }

    public function login($id = null)
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

        if ($id === 'you-got-clickbaited') {
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }

    public function create($id = null)
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUniq = UserModel::emailUniq($_POST['email']);

        if ($passMatch && $isEmailValid && $isEmailUniq) {
            echo 'Success!';
        } else {
            echo 'Check email and password';
        }

        if ($id === 'you-got-clickbaited') {
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }
}