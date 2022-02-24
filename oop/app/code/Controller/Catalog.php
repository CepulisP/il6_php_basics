<?php

namespace Controller;

use Core\AbstractModel;
use Helper\FormHelper;
use Helper\Logger;
use Model\Comment;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Model\User as UserModel;
use Helper\Url;
use Model\Ad;
use Core\AbstractController;

class Catalog extends AbstractController
{
    public function index()
    {
        $form = new FormHelper('catalog/', 'GET');
        $form->label('sort', 'Sort by: ', 0);
        $this->sortForm($form);

        $showSelect = [
            'name' => 'show',
            'id' => 'show',
            'options' => [
                '5' => '5',
                '10' => '10',
                '20' => '20',
                '50' => '50',
                '100' => '100'
            ]
        ];


        if (isset($_GET['show'])) {
            $showSelect['selected'] = $_GET['show'];
        }

        $form->label('show', ' Ads per page: ', 0);
        $form->select($showSelect, 0);

        $adCount = Ad::count();
        $adsPerPage = 5;

        if (!empty($_GET['show'])) {
            $adsPerPage = $_GET['show'];
        }

        $pageCount = ceil($adCount / $adsPerPage);
        $options = [];

        for ($i = 1; $i <= $pageCount; $i++) {
            $options[$i] = $i;
        }

        $pageSelect = [
            'name' => 'p',
            'id' => 'page',
            'options' => $options
        ];

        if (!empty($_GET['p'])) {
            $pageSelect['selected'] = $_GET['p'];
        }

        $form->label('page', ' Page: ', 0);
        $form->select($pageSelect, 0);
        $form->input([
            'type' => 'submit',
            'value' => 'Enter'
        ]);

        $ads = Ad::getOrderedAds('created_at', 'DESC', true, $adsPerPage);

        switch ($ads) {
            case !empty($_GET['sort']) && !empty($_GET['p']):
                $firstAd = ($_GET['p'] - 1) * $adsPerPage;
                $sort = explode('_', $_GET['sort'], 2);
                $ads = Ad::getOrderedAds($sort[1], strtoupper($sort[0]), true, $adsPerPage, $firstAd);
                break;
            case !empty($_GET['p']):
                $firstAd = ($_GET['p'] - 1) * $adsPerPage;
                $ads = Ad::getAllAds(true, $adsPerPage, $firstAd);
                break;
            case !empty($_GET['sort']):
                $sort = explode('_', $_GET['sort'], 2);
                $ads = Ad::getOrderedAds($sort[1], strtoupper($sort[0]), true, $adsPerPage);
                break;
            default:
                break;
        }

        $this->data['form'] = $form->getForm();
        $this->data['ads'] = $ads;
        $this->render('catalog/all');
    }

    public function show($slug)
    {
        $ad = new Ad();
        $ad->loadBySlug($slug);
        $adId = $ad->getId();

        $form = new FormHelper('catalog/addcomment/' . $adId, 'POST');

        $form->input([
            'name' => 'slug',
            'type' => 'hidden',
            'value' => $slug
        ]);
        $form->label('comment', 'Add comment: ');
        $form->textArea('comment', null, 'Add comment', 'comment', 255);
        $form->input([
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Comment'
        ]);

        if (!$ad->isActive()) {
            Url::redirect('catalog/all');
        }

        $adViews = $ad->getViews();
        $adViews++;
        $ad->setViews($adViews);
        $ad->save();

//        Nesekmingas bandymas gaut related pagal title
//        $title = explode(' ', $ad->getTitle());
//        $relatedAds = [];
//
//        for ($i = 0; $i < count($title); $i++){
//            $relatedAds[] = Ad::getAds($title[$i], 'title', 'DESC', 'views', 5);
//        }

//        $related = Ad::getAds($ad->getModelId(), 'model_id', '=', null, null, 5);
//
//        if (!empty($related)) {
//            foreach ($related as $element) {
//                if ($element->getSlug() !== $slug) {
//                    $relatedAds[] = $element;
//                }
//            }
//        }
//
//        if (!empty($relatedAds)){
//            $this->data['related'] = $relatedAds;
//        }else{
//            $this->data['related'] = [];
//        }

        $this->data['ad'] = $ad;
        $this->data['author'] = $ad->getUser();
        $this->data['comment_box'] = $form->getForm();
        $this->data['comments'] = Comment::getAdComments($adId, 10);

        $this->render('catalog/show');
    }

    public function search()
    {
        $form = new FormHelper('catalog/search', 'GET');

        $this->searchForm($form);

        if (isset($_GET['search']) && isset($_GET['field'])) {
            $ads = Ad::getAdsLike($_GET['field'], $_GET['search']);

            if (!empty($ads)) {
                $form->label('sort', ' Sort by: ', 0);
                $this->sortForm($form);

                if (!empty($_GET['sort'])) {
                    $sort = explode('_', $_GET['sort'], 2);

                    $ads = Ad::getOrderedAdsLike($sort[1], strtoupper($sort[0]), $_GET['field'], $_GET['search']);
                }
                $this->data['ads'] = $ads;
            }
        }

        $form->input([
            'type' => 'submit',
            'value' => 'Enter'
        ]);

        $this->data['form'] = $form->getForm();

        $this->render('catalog/search');
    }

    private function sortForm($form)
    {
        $sort = [
            'name' => 'sort',
            'id' => 'sort',
            'options' => [
                'desc_created_at' => 'Newer to older',
                'asc_created_at' => 'Older to newer',
                'desc_price' => 'Price: High to low',
                'asc_price' => 'Price: Low to high',
                'asc_title' => 'A - Z',
                'desc_title' => 'Z - A'
            ],
        ];
        if (isset($_GET['sort'])) {
            $sort['selected'] = $_GET['sort'];
        }
        $form->select($sort, 0);
    }

    private function searchForm($form)
    {

        $searchBox = [
            'name' => 'search',
            'type' => 'text',
            'id' => 'search_box'
        ];
        $searchField = [
            'name' => 'field',
            'id' => 'search_field',
            'options' => [
                'title' => 'Title',
                'description' => 'Description',
            ]
        ];

        if (isset($_GET['search'])) {
            $searchBox['value'] = $_GET['search'];
        }
        if (isset($_GET['field'])) {
            $searchField['selected'] = $_GET['field'];
        }

        $form->label('search_box', 'Keyword or phrase: ', 0);
        $form->input($searchBox, 0);
        $form->label('search_field', ' in ', 0);
        $form->select($searchField, 0);
    }

    public function addComment($id)
    {
        if (!isset($_POST['comment'])) {
            Url::redirect('catalog/show/' . $_POST['slug']);
        }
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['comment_error'] = 'You need to be logged in to comment';
            Url::redirect('catalog/show/' . $_POST['slug']);
        }

        $comment = new Comment();
        $comment->setComment($_POST['comment']);
        $comment->setAdId($id);
        $comment->setUserId($_SESSION['user_id']);
        $comment->save();

        Url::redirect('catalog/show/' . $_POST['slug']);
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('catalog/create/', 'POST');

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title'
        ]);
        $form->textArea('description');

        $manufacturers = Manufacturer::getManufacturers();
        $options = [];

        foreach ($manufacturers as $manufacturer) {
            $options[$manufacturer->getId()] = $manufacturer->getName();
        }

        $form->select([
            'name' => 'manufacturer_id',
            'options' => $options
        ]);

        $models = Model::getModels();
        $options = [];

        foreach ($models as $model) {
            $options[$model->getId()] = $model->getName();
        }

        $form->select([
            'name' => 'model_id',
            'options' => $options
        ]);
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'step' => '0.01',
            'placeholder' => 'Price'
        ]);

        $options = [];

        for ($i = 1990; $i <= date('Y'); $i++) {
            $options[$i] = $i;
        }

        $form->select([
            'name' => 'year',
            'options' => $options
        ]);

        $types = Type::getTypes();
        $options = [];

        foreach ($types as $type) {
            $options[$type->getId()] = $type->getName();
        }

        $form->select([
            'name' => 'type_id',
            'options' => $options
        ]);
        $form->input([
            'name' => 'image',
            'type' => 'text',
            'placeholder' => 'Image.png'
        ]);
        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'placeholder' => 'VIN'
        ]);
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Create'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('catalog/add');
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $ad = new Ad($id);

        if ($_SESSION['user_id'] !== $ad->getUserId()) {
            Url::redirect('');
        }

        $form = new FormHelper('catalog/update', 'POST');

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title',
            'value' => $ad->getTitle()
        ]);
        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $id
        ]);
        $form->textArea('description', $ad->getDescription());

        $manufacturers = Manufacturer::getManufacturers();
        $options = [];

        foreach ($manufacturers as $manufacturer) {
            $options[$manufacturer->getId()] = $manufacturer->getName();
        }

        $form->select([
            'name' => 'manufacturer_id',
            'options' => $options,
            'selected' => $ad->getManufacturerId()
        ]);

        $models = Model::getModels();
        $options = [];

        foreach ($models as $model) {
            $options[$model->getId()] = $model->getName();
        }

        $form->select([
            'name' => 'model_id',
            'options' => $options,
            'selected' => $ad->getModelId()
        ]);
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'step' => '0.01',
            'placeholder' => 'Price',
            'value' => $ad->getPrice()
        ]);

        $options = [];

        for ($i = 1990; $i <= date('Y'); $i++) {
            $options[$i] = $i;
        }

        $form->select([
            'name' => 'year',
            'options' => $options,
            'selected' => $ad->getYear()
        ]);

        $types = Type::getTypes();
        $options = [];

        foreach ($types as $type) {
            $options[$type->getId()] = $type->getName();
        }

        $form->select([
            'name' => 'type_id',
            'options' => $options,
            'selected' => $ad->getTypeId()
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
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Create'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('catalog/edit');
    }

    public function create()
    {
        $slug = Url::generateSlug($_POST['title']);

        while (!Ad::isValueUniq('slug', $slug)) {
            $slug .= '-' . rand(0, 999999);
        }

        $ad = new Ad();

        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setImage($_POST['image']);
        $ad->setVin($_POST['vin']);
        $ad->setUserId($_SESSION['user_id']);
        $ad->setSlug($slug);
        $ad->setActive(1);

        $ad->save();

        Url::redirect('');
    }

    public function update()
    {
        $ad = new Ad($_POST['id']);

        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setImage($_POST['image']);
        $ad->setVin($_POST['vin']);

        $ad->save();

        Url::redirect('');
    }
}