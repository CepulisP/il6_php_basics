<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Model extends AbstractModel implements ModelInterface
{
    private string $name;

    private int $manufacturerId;

    protected const TABLE = 'models';

    public function __construct(?int $id = null)
    {
        if ($id !== null){
            $this->load($id);
        }
    }

    public function assignData(): void {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getManufacturerId(): int
    {
        return $this->manufacturerId;
    }

    public function load(int $id): ?Model
    {
        $db = new DBHelper();
        $model = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($model)) {
            $this->id = (int)$model['id'];
            $this->name = $model['name'];
            $this->manufacturerId = (int)$model['manufacturer_id'];
            return $this;
        }
        return null;
    }

    public static function getModels(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $models = [];

        foreach ($data as $element) {
            $model = new Model((int)$element['id']);
            $models[] = $model;
        }

        return $models;
    }

    public static function getModelsByManufacturer(int $id): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('manufacturer_id', $id)->get();
        $models = [];

        foreach ($data as $element) {
            $model = new Model((int)$element['id']);
            $models[] = $model;
        }

        return $models;
    }
}