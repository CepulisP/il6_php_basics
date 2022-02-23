<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;
use Helper\Logger;

class Ad extends AbstractModel
{
    private $title;

    private $description;

    private $manufacturerId;

    private $manufacturer;

    private $modelId;

    private $model;

    private $price;

    private $year;

    private $typeId;

    private $type;

    private $userId;

    private $image;

    private $active;

    private $slug;

    private $createdAt;

    private $vin;

    private $views;

    protected const TABLE = 'ads';

    public function __construct($id = null)
    {
        if ($id !== null){
            $this->load($id, 'id');
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    public function setManufacturerId($manufacturerId)
    {
        $this->manufacturerId = $manufacturerId;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function getModelId()
    {
        return $this->modelId;
    }

    public function setModelId($modelId)
    {
        $this->modelId = $modelId;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUser()
    {
        $array = User::getUser($this->userId);
        return $array[0];
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getVin()
    {
        return $this->vin;
    }

    public function setVin($vin)
    {
        $this->vin = $vin;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    protected function assignData()
    {
        $this->data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturerId,
            'model_id' => $this->modelId,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->typeId,
            'user_id' => $this->userId,
            'image' => $this->image,
            'active' => $this->active,
            'slug' => $this->slug,
            'vin' => $this->vin,
            'views' => $this->views
        ];
    }

    public function load($value, $field)
    {
        $man = new Manufacturer();
        $model = new Model();
        $type = new Type();
        $user = new User();
        $db = new DBHelper();

        $ad = $db->select()->from(self::TABLE)->where($field, $value)->getOne();

        if (!empty($ad)) {
            $this->id = $ad['id'];
            $this->title = $ad['title'];
            $this->description = $ad['description'];
            $this->manufacturerId = $ad['manufacturer_id'];
            $this->manufacturer = $man->load($this->manufacturerId)->getName();
            $this->modelId = $ad['model_id'];
            $this->model = $model->load($this->modelId)->getName();
            $this->price = $ad['price'];
            $this->year = $ad['year'];
            $this->typeId = $ad['type_id'];
            $this->type = $type->load($this->typeId)->getName();
            $this->userId = $ad['user_id'];
            $this->image = $ad['image'];
            $this->active = $ad['active'];
            $this->slug = $ad['slug'];
            $this->createdAt = $ad['created_at'];
            $this->vin = $ad['vin'];
            $this->views = $ad['views'];
        }

        return $this;
    }

//    public static function getAllAds($limit = null)
//    {
//        $db = new DBHelper();
//
//        $db->select()->from('ads')->where('active', 1);
//
//        if (isset($limit)) {
//            $db->limit($limit);
//        }
//
//        $data = $db->get();
//
//        $ads = [];
//
//        foreach ($data as $element) {
//            $ad = new Ad();
//            $ad->load($element['id'], 'id');
//            $ads[] = $ad;
//        }
//
//        return $ads;
//    }
//
//    public static function getAdsLike($value, $field, $limit = null)
//    {
//        $db = new DBHelper();
//
//        $value = '%' . $value . '%';
//
//        $db->select()->from('ads')->where($field, $value, 'LIKE')->andWhere('active', 1);
//
//        if (isset($limit)) {
//            $db->limit($limit);
//        }
//
//        $data = $db->get();
//
//        $ads = [];
//
//        foreach ($data as $element) {
//            $ad = new Ad();
//            $ad->load($element['id'], 'id');
//            $ads[] = $ad;
//        }
//
//        return $ads;
//    }
//
//    public static function getOrderedAds($field, $order, $limit = null)
//    {
//        $db = new DBHelper();
//
//        $db->select()->from('ads')->where('active', 1)->orderby($field, $order);
//
//        if (isset($limit)) {
//            $db->limit($limit);
//        }
//
//        $data = $db->get();
//
//        $ads = [];
//
//        foreach ($data as $element) {
//            $ad = new Ad();
//            $ad->load($element['id'], 'id');
//            $ads[] = $ad;
//        }
//
//        return $ads;
//    }

    public static function getAds(
        $searchValue= null,
        $searchField = null,
        $searchOperator = null,
        $orderMethod = null,
        $orderField = null,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE)->where('active', 1);

        if (isset($searchField) && isset($searchValue)) {

            if ($searchOperator == 'LIKE') {
                $searchValue = '%' . $searchValue . '%';
            }
            $db->andWhere($searchField, $searchValue, $searchOperator);
        }

        if (isset($orderMethod) && isset($orderField)) {
            $db->orderby($orderField, $orderMethod);
        }

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element['id'], 'id');
            $ads[] = $ad;
        }

        return $ads;
    }

//    This will be redone soon(tm)
    public static function getAllAds(
        $searchValue= null,
        $searchField = null,
        $searchOperator = null,
        $orderMethod = null,
        $orderField = null,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if (isset($searchField) && isset($searchValue)) {

            if ($searchOperator == 'LIKE') {
                $searchValue = '%' . $searchValue . '%';
            }
            $db->where($searchField, $searchValue, $searchOperator);
        }

        if (isset($orderMethod) && isset($orderField)) {
            $db->orderby($orderField, $orderMethod);
        }

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element['id'], 'id');
            $ads[] = $ad;
        }

        return $ads;
    }
}