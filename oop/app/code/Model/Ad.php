<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Ad extends AbstractModel
{
    private $title;

    private $description;

    private $manufacturer_id;

    private $model_id;

    private $price;

    private $year;

    private $type_id;

    private $user_id;

    private $image;

    private $active;

    private $slug;

    private $createdAt;

    private $vin;

    private $views;

    public function __construct()
    {
        $this->table = 'ads';
    }

    protected function assignData()
    {
        $this->data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
            'image' => $this->image,
            'active' => $this->active,
            'slug' => $this->slug,
            'vin' => $this->vin,
            'views' => $this->views
        ];
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
        return $this->manufacturer_id;
    }

    public function setManufacturerId($manufacturer_id)
    {
        $this->manufacturer_id = $manufacturer_id;
    }

    public function getModelId()
    {
        return $this->model_id;
    }

    public function setModelId($model_id)
    {
        $this->model_id = $model_id;
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
        return $this->type_id;
    }

    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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

    public function load($value, $field)
    {
        $db = new DBHelper();
        $ad = $db->select()->from($this->table)->where($field, $value)->getOne();

        if (!empty($ad)) {
            $this->id = $ad['id'];
            $this->title = $ad['title'];
            $this->description = $ad['description'];
            $this->manufacturer_id = $ad['manufacturer_id'];
            $this->model_id = $ad['model_id'];
            $this->price = $ad['price'];
            $this->year = $ad['year'];
            $this->type_id = $ad['type_id'];
            $this->user_id = $ad['user_id'];
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
        $orderMethod = null,
        $orderField = null,
        $limit = null,
        $limitOffset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from('ads')->where('active', 1);

        if (isset($searchField) && isset($searchValue)) {
            $searchValue = '%' . $searchValue . '%';
            $db->andWhere($searchField, $searchValue, 'LIKE');
        }

        if (isset($orderMethod) && isset($orderField)) {
            $db->orderby($orderField, $orderMethod);
        }

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($limitOffset)) {
            $db->offset($limitOffset);
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