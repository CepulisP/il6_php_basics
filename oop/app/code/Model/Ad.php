<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Ad extends AbstractModel
{
    private $id;

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

    public function getId()
    {
        return $this->id;
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

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function save()
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    private function create()
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
            'image' => $this->image,
            'active' => $this->active
        ];

        $db = new DBHelper();
        $db->insert('ads', $data)->exec();
    }

    private function update()
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
            'image' => $this->image,
            'active' => $this->active
        ];

        $db = new DBHelper();
        $db->update('ads', $data)->where('id', $this->id)->exec();
    }

    public function load($id)
    {
        $db = new DBHelper();
        $ad = $db->select()->from('ads')->where('id', $id)->getOne();

        if (!empty($ad)){
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
        }

        return $this;
    }

    public function delete()
    {

    }

    public static function getAllAds()
    {
        $db = new DBHelper();
        $data = $db->select()->from('ads')->get();
        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }
}