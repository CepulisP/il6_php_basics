<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\Csv;
use Helper\Url;
use Model\Ad;
use Model\Manufacturer;
use Model\Model;
use Model\Type;

class Database extends AbstractController implements ControllerInterface
{
    public function index(): void
    {
        $this->render('database/index');
    }

    public function import(): void
    {
        if (!isset($_POST['file_name'])) Url::redirect('database');

        $csvPath = PROJECT_ROOT_DIR . '\var\imports\\' . $_POST['file_name'];
        $ads = Csv::csvToArray($csvPath);

        if (empty($ads)) Url::redirect('database');

        foreach ($ads as $adData) {

            $ad = new Ad();
            $man = new Manufacturer();
            $model = new Model();
            $type = new Type();

            if (Manufacturer::isValueUniq('name', $adData['manufacturer'])) {
                $man->setName($adData['manufacturer']);
                $man->save();
            }
            if (Model::isValueUniq('name', $adData['model'])) {
                $model->setName($adData['model']);
                $model->setManufacturerId($man->loadByName($adData['manufacturer'])->getId());
                $model->save();
            }
            if (Type::isValueUniq('name', $adData['type'])) {
                $type->setName($adData['type']);
                $type->save();
            }

            $slug = Url::generateSlug($adData['title']);

            while (!Ad::isValueUniq('slug', $slug)) {
                $slug .= '-' . rand(0, 999999);
            }

            $ad->setTitle($adData['title']);
            $ad->setDescription($adData['description']);
            $ad->setManufacturerId($man->loadByName($adData['manufacturer'])->getId());
            $ad->setModelId($model->loadByName($adData['model'])->getId());
            $ad->setPrice((float)$adData['price']);
            $ad->setYear((int)$adData['year']);
            $ad->setTypeId($type->loadByName($adData['type'])->getId());
            $ad->setImage($adData['image']);
            $ad->setVin($adData['vin']);
            $ad->setUserId(38);
            $ad->setSlug($slug);
            $ad->setViews(0);
            $ad->setActive(1);
            $ad->save();
        }
        unlink($csvPath);
        Url::redirect('database');
    }

    public function export(): void
    {
        //To do: complete export
        Url::redirect('database');
    }
}