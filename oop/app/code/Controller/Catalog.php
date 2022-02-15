<?php

namespace Controller;

use Helper\FormHelper;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Model\User as UserModel;
use Helper\Url;
use Model\Ad;
use Core\AbstractController;

class Catalog extends AbstractController
{
    public function show($slug)
    {
        $ad = new Ad();
        $user = new UserModel();
        $manufacturer = new Manufacturer();
        $model = new Model();
        $type = new Type();

        $this->data['ad'] = $ad->load($slug, 'slug');
        $this->data['user_name'] = ucfirst($user->load($ad->getUserId())->getName());
        $this->data['user_last_name'] = ucfirst($user->load($ad->getUserId())->getLastName());
        $this->data['manufacturer'] = ucfirst($manufacturer->load($ad->getManufacturerId())->getName());
        $this->data['model'] = ucfirst($model->load($ad->getModelId())->getName());
        $this->data['type'] = ucfirst($type->load($ad->getTypeId())->getName());

        if (!$ad->isActive()) {
            Url::redirect('catalog/all');
        }

        $this->render('catalog/show');
    }

    public function all()
    {
        $form = new FormHelper('catalog/all', 'GET');
        $this->sortForm($form);
        $form->input(['type' => 'submit', 'value' => 'Enter']);
        $this->data['form'] = $form->getForm();

        $ads = Ad::getAllAds();

        if (isset($_GET['sort'])) {
            $ads = $this->orderBy($_GET['sort'], $ads);
        }

        $this->data['ads'] = $ads;

        $this->render('catalog/all');
    }

    public function search()
    {
        $form = new FormHelper('catalog/search', 'GET');

        $this->searchForm($form, '');

        if (isset($_GET['search']) && isset($_GET['field'])) {
            $ads = Ad::getAllAds($_GET['search'], $_GET['field']);

            if (!empty($ads)) {
                $form->addText('<br>Sort by:<br>');
                $this->sortForm($form);

                if (isset($_GET['sort'])) {
                    $ads = $this->orderBy($_GET['sort'], $ads);
                }

                $this->data['ads'] = $ads;
            }
        }

        $form->input(['type' => 'submit', 'value' => 'Enter']);
        $this->data['form'] = $form->getForm();


        $this->render('catalog/search');
    }

    private function sortForm($form)
    {
        if (isset($_GET['sort'])) {
            $form->select([
                'name' => 'sort',
                'options' => [
                    'null' => '',
                    'ascending_date' => 'Older to newer',
                    'descending_date' => 'Newer to older',
                    'ascending_price' => 'Price: Low to high',
                    'descending_price' => 'Price: High to low',
                    'ascending_title' => 'A - Z',
                    'descending_title' => 'Z - A'
                ],
                'selected' => $_GET['sort']
            ]);
        } else {
            $form->select([
                'name' => 'sort',
                'options' => [
                    'null' => '',
                    'ascending_date' => 'Older to newer',
                    'descending_date' => 'Newer to older',
                    'ascending_price' => 'Price: Low to high',
                    'descending_price' => 'Price: High to low',
                    'ascending_title' => 'A - Z',
                    'descending_title' => 'Z - A'
                ]
            ]);
        }
    }

    private function searchForm($form, $br = null)
    {
        $form->addText('Keyword or phrase: ');
        if (isset($_GET['search']) && isset($_GET['field'])) {
            $form->input(['name' => 'search', 'type' => 'text', 'value' => $_GET['search']], '');
            $form->addText(' in ');
            $form->select([
                'name' => 'field',
                'options' => [
                    'null' => '',
                    'title' => 'Title',
                    'description' => 'Description',
                ],
                'selected' => $_GET['field']
            ], $br);
        } else {
            $form->input(['name' => 'search', 'type' => 'text'], '');
            $form->addText(' in ');
            $form->select([
                'name' => 'field',
                'options' => [
                    'null' => '',
                    'title' => 'Title',
                    'description' => 'Description'
                ]
            ], $br);
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
        $form->input(['name' => 'image', 'type' => 'text', 'placeholder' => 'Image.png']);
        $form->input(['name' => 'vin', 'type' => 'text', 'placeholder' => 'VIN']);

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
        $ad->load($id, 'id');

        if ($_SESSION['user_id'] !== $ad->getUserId()) {
            Url::redirect('');
        }

        $form = new FormHelper('catalog/update', 'POST');

        $form->input(['name' => 'title', 'type' => 'text', 'placeholder' => 'Title', 'value' => $ad->getTitle()]);
        $form->input(['name' => 'id', 'type' => 'hidden', 'value' => $id]);
        $form->textArea('description', $ad->getDescription());
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'step' => '0.01',
            'placeholder' => 'Price',
            'value' => $ad->getPrice()
        ]);
        $form->input([
            'name' => 'image',
            'type' => 'text',
            'placeholder' => 'Image name',
            'value' => $ad->getImage()
        ]);
        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'placeholder' => 'VIN',
            'value' => $ad->getVin()
        ]);

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
        $slug = Url::generateSlug($_POST['title']);

        while (!Ad::isValueUniq('slug', $slug, 'ads')) {
            $slug .= '-' . rand(0, 999999);
        }

        $ad = new Ad();
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId(1);
        $ad->setModelId(1);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId(1);
        $ad->setUserId($_SESSION['user_id']);
        $ad->setImage($_POST['image']);
        $ad->setActive(1);
        $ad->setSlug($slug);
        $ad->setVin($_POST['vin']);
        $ad->save();

        Url::redirect('');
    }

    public function update()
    {
        $adId = $_POST['id'];
        $ad = new Ad();
        $ad->load($adId, 'id');
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId(1);
        $ad->setModelId(1);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId(1);
        $ad->setImage($_POST['image']);
        $ad->setVin($_POST['vin']);
        $ad->save();

        Url::redirect('');
    }

    private function orderBy($method, $data)
    {
        switch ($method) {
            case 'ascending_date':
                $date = [];
                foreach ($data as $key => $row) {
                    $date[$key] = $row->getCreatedAt();
                }
                array_multisort($date, SORT_ASC, $data);
                break;
            case 'descending_date':
                $date = [];
                foreach ($data as $key => $row) {
                    $date[$key] = $row->getCreatedAt();
                }
                array_multisort($date, SORT_DESC, $data);
                break;
            case 'ascending_price':
                $price = [];
                foreach ($data as $key => $row) {
                    $price[$key] = $row->getPrice();
                }
                array_multisort($price, SORT_ASC, $data);
                break;
            case 'descending_price':
                $price = [];
                foreach ($data as $key => $row) {
                    $price[$key] = $row->getPrice();
                }
                array_multisort($price, SORT_DESC, $data);
                break;
            case 'ascending_title':
                $title = [];
                foreach ($data as $key => $row) {
                    $title[$key] = $row->getTitle();
                }
                array_multisort($title, SORT_ASC, $data);
                break;
            case 'descending_title':
                $title = [];
                foreach ($data as $key => $row) {
                    $title[$key] = $row->getTitle();
                }
                array_multisort($title, SORT_DESC, $data);
                break;
        }
        return $data;
    }
}