<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractController;
use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Manufacturer extends AbstractModel implements ModelInterface
{
    private string $name;

    protected const TABLE = 'manufacturers';

    public function __construct(?int $id = null)
    {
        if ($id !== null){
            $this->load($id);
        }
    }

    public function assignData(): void
    {
        $this->data = [
            'name' => $this->name
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $manufacturer): void
    {
        $this->name = $manufacturer;
    }

    public function load(int $id): ?Manufacturer
    {
        $db = new DBHelper();
        $manufacturer = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($manufacturer)) {
            $this->id = (int)$manufacturer['id'];
            $this->name = $manufacturer['name'];
            return $this;
        }
        return null;
    }

    public function loadByName(string $name): ?Manufacturer
    {
        $db = new DBHelper();
        $manufacturer = $db->select()->from(self::TABLE)->where('name', $name)->getOne();

        if (!empty($manufacturer)) {
            $this->id = (int)$manufacturer['id'];
            $this->name = $manufacturer['name'];
            return $this;
        }
        return null;
    }

    public static function getManufacturers(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $manufacturers = [];

        foreach ($data as $element) {
            $manufacturer = new Manufacturer((int)$element['id']);
            $manufacturers[] = $manufacturer;
        }

        return $manufacturers;
    }
}