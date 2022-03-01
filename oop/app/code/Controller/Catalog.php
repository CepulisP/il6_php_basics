<?php

namespace Controller;

use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Logger;
use Model\Comment;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Helper\Url;
use Model\Ad;
use Core\AbstractController;

class Catalog extends AbstractController implements ControllerInterface
{
    private const ITEMS_PER_PAGE = 10;

    public function index()
    {
        $form = new FormHelper('catalog/', 'GET');

        $this->sortForm($form);
        $this->pageForm($form, Ad::count());
        $form->input([
            'type' => 'submit',
            'value' => 'Enter'
        ]);

        $this->data['form'] = $form->getForm();
        $this->data['ads'] = Catalog::getRequestedAds();
        $this->render('catalog/all');
    }

    public function show($slug)
    {
        $ad = new Ad();
        $ad->loadBySlug($slug);
        $adId = $ad->getId();

        if (!$ad->isActive()) Url::redirect('catalog/all');

        $form = new FormHelper('catalog/addcomment/?id=' . $adId . '&back=' . $slug, 'POST');

        $form->label('comment', 'Add comment: ');
        $form->textArea('comment', null, 'Add comment', 'comment', 255);

        $nr1 = rand(0, 10);
        $nr2 = rand(0, 10);

        $form->input([
            'name' => 'answer',
            'type' => 'hidden',
            'value' => $nr1 + $nr2
        ]);
        $form->label('human_check', 'What\'s ' . $nr1 . '+' . $nr2 . '? ', 0);
        $form->input([
            'name' => 'human_check',
            'id' => 'human_check',
            'type' => 'number'
        ]);
        $form->input([
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Comment'
        ]);

        $adViews = $ad->getViews();
        $adViews++;
        $ad->setViews($adViews);
        $ad->save();

        $this->data['related'] = Ad::getRelatedAds($adId, 5);
        $this->data['ad'] = $ad;
        $this->data['author'] = $ad->getUser();
        $this->data['comment_box'] = $form->getForm();
        $this->data['comments'] = $ad->getComments();

        $this->render('catalog/show');
    }

    public function search()
    {
        $form = new FormHelper('catalog/search', 'GET');

        $this->searchForm($form);
        $this->sortForm($form);

        if (isset($_GET['search']) && isset($_GET['field'])) {
            $ads = Catalog::getRequestedAds(true);
            $this->pageForm($form, $ads['ad_count']);
            $this->data['ads'] = $ads['ads'];
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
                'DESC_created_at' => 'Newer to older',
                'ASC_created_at' => 'Older to newer',
                'DESC_price' => 'Price: High to low',
                'ASC_price' => 'Price: Low to high',
                'ASC_title' => 'A - Z',
                'DESC_title' => 'Z - A'
            ],
        ];
        if (isset($_GET['sort'])) $sort['selected'] = $_GET['sort'];
        $form->label('sort', 'Sort by: ', 0);
        $form->select($sort);
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

        if (isset($_GET['search'])) $searchBox['value'] = $_GET['search'];
        if (isset($_GET['field'])) $searchField['selected'] = $_GET['field'];

        $form->label('search_box', 'Keyword or phrase: ', 0);
        $form->input($searchBox, 0);
        $form->label('search_field', ' in ', 0);
        $form->select($searchField);
    }

    private function pageForm($form, $adCount)
    {
        $showSelect = [
            'name' => 'show',
            'id' => 'show',
            'selected' => self::ITEMS_PER_PAGE,
            'options' => [
                '5' => '5',
                '10' => '10',
                '20' => '20',
                '50' => '50',
                '100' => '100'
            ]
        ];

        if (!empty($_GET['show'])) $showSelect['selected'] = $_GET['show'];

        $adsPerPage = self::ITEMS_PER_PAGE;

        if (!empty($_GET['show'])) $adsPerPage = $_GET['show'];

        $pageCount = ceil($adCount / $adsPerPage);
        $options = [];

        for ($i = 1; $i <= $pageCount; $i++) {
            $options[$i] = $i;
        }

        $pageSelect = [
            'name' => 'p',
            'id' => 'page',
            'selected' => 1,
            'options' => $options
        ];

        if (!empty($_GET['p'])) $pageSelect['selected'] = $_GET['p'];

        $form->label('show', ' Ads per page: ', 0);
        $form->select($showSelect, 0);
        $form->label('page', ' Page: ', 0);
        $form->select($pageSelect);
    }

    public function addComment()
    {
        if (empty($_POST['comment'])) Url::redirect('catalog/show/' . $_GET['back']);
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['comment_error'] = 'You need to be logged in to comment';
            Url::redirect('catalog/show/' . $_GET['back']);
        }
        if ($_POST['human_check'] !== $_POST['answer']){
            $_SESSION['comment_error'] = 'Human check failed';
            Url::redirect('catalog/show/' . $_GET['back']);
        }

        $comment = new Comment();
        $comment->setComment($_POST['comment']);
        $comment->setAdId($_GET['id']);
        $comment->setUserId($_SESSION['user_id']);
        $comment->setUserIp($_SERVER['REMOTE_ADDR']);
        $comment->save();

        unset($_SESSION['comment_error']);
        Url::redirect('catalog/show/' . $_GET['back']);
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) Url::redirect('user/login');

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
            'placeholder' => 'Image url'
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
        if (!isset($_SESSION['user_id'])) Url::redirect('user/login');

        $ad = new Ad($id);

        if ($_SESSION['user_id'] !== $ad->getUserId()) Url::redirect('');

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

    private static function getRequestedAds($returnCount = false)
    {
        $page = !empty($_GET['p']) ? $_GET['p'] : 1;
        $adsPerPage = !empty($_GET['show']) ? $_GET['show'] : self::ITEMS_PER_PAGE;
        $firstAd = ($page - 1) * $adsPerPage;
        $sort = !empty($_GET['sort']) ? explode('_', $_GET['sort'], 2) : ['DESC', 'created_at'];
        $orderField = $sort[1];
        $orderMethod = $sort[0];
        $searchField = !empty($_GET['field']) ? $_GET['field'] : null;
        $searchValue = !empty($_GET['search']) ? $_GET['search'] : null;

        if (!empty($searchField) && !empty($searchValue)) {
            $ads = Ad::getOrderedAdsLike($orderField, $orderMethod, $searchField, $searchValue, true, $adsPerPage, $firstAd);
            if ($returnCount){
                return ['ads' => $ads, 'ad_count' => count(Ad::getOrderedAdsLike($orderField, $orderMethod, $searchField, $searchValue))];
            }
            return $ads;
        }else{
            $ads = Ad::getOrderedAds($orderField, $orderMethod, true, $adsPerPage, $firstAd);
            if ($returnCount){
                return ['ads' => $ads, 'ad_count' => count(Ad::getOrderedAds($orderField, $orderMethod))];
            }
            return $ads;
        }
    }
}