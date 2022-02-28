<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\Logger;

class Ad extends AbstractModel implements ModelInterface
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
        if ($id !== null) {
            $this->load($id);
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

    public function getUser()
    {
        return new User($this->userId);
    }

    public function getComments($limit = null)
    {
        return Comment::getAdComments($this->id, $limit);
    }

    public function assignData()
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

    public function load($id)
    {
        $man = new Manufacturer();
        $model = new Model();
        $type = new Type();
        $user = new User();
        $db = new DBHelper();

        $ad = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

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

    public function loadBySlug($slug)
    {
        $man = new Manufacturer();
        $model = new Model();
        $type = new Type();
        $user = new User();
        $db = new DBHelper();

        $ad = $db->select()->from(self::TABLE)->where('slug', $slug)->getOne();

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

    public static function getAllAds(
        $activeOnly = true,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
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
            $ad = new Ad($element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getOrderedAds(
        $orderField,
        $orderMethod,
        $activeOnly = true,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        $db->orderby($orderField, $orderMethod);

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad($element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getAdsLike(
        $searchField,
        $searchValue,
        $activeOnly = true,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        $db->andWhere($searchField, '%' . $searchValue . '%', 'LIKE');

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad($element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getOrderedAdsLike(
        $orderField,
        $orderMethod,
        $searchField,
        $searchValue,
        $activeOnly = true,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        $db->andWhere($searchField, '%' . $searchValue . '%', 'LIKE')->orderby($orderField, $orderMethod);

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }
        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad($element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getUserAds(
        $userId,
        $activeOnly = true,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        $db->andWhere('user_id', $userId);

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad($element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }
}