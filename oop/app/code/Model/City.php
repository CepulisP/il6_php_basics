<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class City extends AbstractModel implements ModelInterface
{
    private string $name;

    protected const TABLE = 'cities';

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

    public function load(int $id): ?City
    {
        $db = new DBHelper();
        $city = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($city)) {
            $this->id = (int)$city['id'];
            $this->name = $city['name'];
            return $this;
        }
        return null;
    }

    public static function getCities(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $cities = [];

        foreach ($data as $element) {
            $city = new City((int)$element['id']);
            $cities[] = $city;
        }

        return $cities;
    }
}