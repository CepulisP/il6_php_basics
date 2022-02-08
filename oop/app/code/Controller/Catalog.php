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
        $ad = new Ad();
        $ad->load($id);

        $user = new UserModel();
        $user->load($ad->getUserId());

        $this->data['content'] = '';

        $this->data['content'] .= '<h2>' . $ad->getTitle() . '</h2><br>';
        $this->data['content'] .= '<h3>Description</h3>' . $ad->getDescription() . '<br>';
        $this->data['content'] .= '<br>Manufacturer: ' . $ad->getManufacturerId() . '<br>';
        $this->data['content'] .= 'Model: ' . $ad->getModelId() . '<br>';
        $this->data['content'] .= 'Price: ' . $ad->getPrice() . ' Eur<br>';
        $this->data['content'] .= 'Year of manufacture: ' . $ad->getYear() . '<br>';
        $this->data['content'] .= 'Type: ' . $ad->getTypeId() . '<br>';
        $this->data['content'] .= 'Created by: ' . ucfirst($user->getName()) . ' '
            . ucfirst($user->getLastName()) . '<br>';

        $this->render('catalog/show');
    }

    public function all()
    {
        $ads = Ad::getAllAds();

        $count = 1;

        $this->data['content'] = '<table style="color:white;"><tr>';

        foreach ($ads as $ad) {
            $this->data['content'] .= '<td style="padding:0 50px 0 50px;">';
            $this->data['content'] .= '<b style="font-size:24px;">'.ucfirst($ad->getTitle()) . '</b><br>';
            $this->data['content'] .= $ad->getPrice() . '<br>';
            $this->data['content'] .= '<a href="http://localhost/pamokos/oop/index.php/catalog/show/'
                . $ad->getId()
                . '" style="color:white;">Read more</a><hr><br>';
            $this->data['content'] .= '</td>';
            if ($count % 5 == 0){
                $this->data['content'] .= '</tr><tr>';
            }
            $count++;
        }

        $this->data['content'] .= '</tr></table>';

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
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $ad = new Ad();
        $ad->load($id);

        if ($_SESSION['user_id'] !== $ad->getUserId()) {
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