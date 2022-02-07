<?php

namespace Controller;

use Helper\FormHelper;
use Model\User as UserModel;
use Helper\Url;
use Model\Ad;
use Core\AbstractController;

class Catalog extends AbstractController
{
    public function show($id = null)
    {
        $this->data['content'] = '';
        if ($id !== null) {
            $this->data['content'] .= 'Catalog controller ID ' . $id;
        } else {
            $this->data['content'] .= '404 no id';
        }
        $this->render('catalog/show');
    }

    public function all()
    {
        $this->data['content'] = '';
        for ($i = 0; $i < 10; $i++) {
            $this->data['content'] .= '<a href="http://localhost/pamokos/oop/index.php/catalog/show/' . $i
                . '" style="color:white;text-decoration:none">Read more</a>';
            $this->data['content'] .= '<br>';
        }
        $this->render('catalog/all');
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

        $this->data['form'] = $form->getForm();
        $this->render('catalog/add');
    }

    public function edit($id)
    {
        $ad = new Ad();
        $ad->load($id);

        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        } elseif ($_SESSION['user_id'] !== $ad->getUserId()) {
            Url::redirect('');
        }

        $form = new FormHelper('catalog/update', 'POST');

        $form->input(['name' => 'title', 'type' => 'text', 'placeholder' => 'Title', 'value' => $ad->getTitle()]);
        $form->input(['name' => 'id', 'type' => 'hidden', 'value' => $id]);
        $form->textArea('description', $ad->getDescription());
        $form->input(['name' => 'price', 'type' => 'number', 'step' => '0.01', 'placeholder' => 'Price', 'value' => $ad->getPrice()]);

        $options = [];

        for ($i = 1990; $i <= date('Y'); $i++) {
            $options[$i] = $i;
        }

        $form->select(['name' => 'year', 'options' => $options, 'selected' => $ad->getYear()]);
        $form->input(['name' => 'create', 'type' => 'submit', 'value' => 'Create']);

        $this->data['form'] = $form->getForm();
        $this->render('catalog/edit');
    }

    public function create()
    {
        $ad = new Ad();
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId(1);
        $ad->setModelId(1);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId(1);
        $ad->setUserId($_SESSION['user_id']);
        $ad->save();

        Url::redirect('');
    }

    public function update()
    {
        $adId = $_POST['id'];
        $ad = new Ad();
        $ad->load($adId);
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId(1);
        $ad->setModelId(1);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId(1);
        $ad->save();

        Url::redirect('');
    }
}