<?php

namespace Controller;

use Helper\FormHelper;
use Model\User as UserModel;
use Helper\Url;
use Model\Ad;

class Catalog
{
    public function show($id = null)
    {
        if ($id !== null) {
            echo 'Catalog controller ID ' . $id;
        } else {
            echo '404 no id';
        }
    }

    public function all()
    {
        for ($i = 0; $i < 10; $i++) {
            echo '<a href="http://localhost/pamokos/oop/index.php/catalog/show/' . $i
                . '" style="color:white;text-decoration:none">Read more</a>';
            echo '<br>';
        }
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('catalog/create/', 'POST');

        $form->input(['name' => 'title', 'type' => 'text', 'placeholder' => 'Title']);
        $form->textArea('description');
        $form->input(['name' => 'price', 'type' => 'number', 'step' => '0.01', 'placeholder' => 'Price']);

        $options = [];

        for ($i = 1990; $i <= date('Y'); $i++) {
            $options[$i] = $i;
        }

        $form->select(['name' => 'year', 'options' => $options]);
        $form->input(['name' => 'create', 'type' => 'submit', 'value' => 'Create']);

        echo $form->getForm();
    }

    public function create()
    {
        $ad = new Ad();
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setUserId($_SESSION['user_id']);
        $ad->save();

        Url::redirect('');
    }

    public function update()
    {
        echo 'I\'m Robot';
    }
}