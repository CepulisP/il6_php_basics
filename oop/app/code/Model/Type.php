<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Type extends AbstractModel implements ModelInterface
{
    private string $name;

    protected const TABLE = 'types';

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

    public function load(int $id): Type
    {
        $db = new DBHelper();
        $type = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$type['id'];
        $this->name = $type['name'];
        return $this;
    }

    public static function getTypes(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $types = [];

        foreach ($data as $element) {
            $type = new Type((int)$element['id']);
            $types[] = $type;
        }

        return $types;
    }
}