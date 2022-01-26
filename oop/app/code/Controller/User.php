<?php

namespace Controller;

use Helper\FormHelper;

class User
{
    public function show($id = null)
    {
        if ($id !== null) {
            echo 'User controller ID ' . $id;
        } else {
            echo '404 no id';
        }

        if ($id === 'you-got-clickbaited'){
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }

    public function register($id = null)
    {
        $form = new FormHelper('*', 'POST');
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

        if ($id === 'you-got-clickbaited'){
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }

    public function login($id = null)
    {
        $form = new FormHelper('*', 'POST');
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
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Login'
        ]);

        echo $form->getForm();

        if ($id === 'you-got-clickbaited'){
            echo '<div class="clickb" style="text-align:center">';
            echo '<b style="font-size:68px;"=>YOU GOT CLICKBAITED!</b>';
            echo '</div>';
            die();
        }
    }
}