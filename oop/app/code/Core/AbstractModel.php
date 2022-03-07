<?php

declare(strict_types=1);

namespace Core;

use Helper\DBHelper;

class AbstractModel
{
    protected array $data;

    protected int $id;

    protected const TABLE = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function save(): void
    {
        $this->assignData();
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    protected function update(): void
    {
        $db = new DBHelper();
        $db->update(static::TABLE, $this->data)->where('id', $this->id)->exec();
    }

    protected function create(): void
    {
        $db = new DBHelper();
        $db->insert(static::TABLE, $this->data)->exec();
    }

    protected function assignData(): void
    {
        $this->data = [];
    }

    public function delete(): void
    {
        $db = new DBHelper();
        $db->delete()->from(static::TABLE)->where('id', $this->id)->exec();
    }

    public static function isValueUniq(string $field, string $value): bool
    {
        $value = strtolower(trim($value));
        $db = new DBHelper();
        $rez = $db->select()->from(static::TABLE)->where($field, $value)->get();
        return empty($rez);
    }

    public static function count(bool $activeOnly = true): int
    {
        $db = new DBHelper();
        $db->select('count(*)')->from(static::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }
        $rez = $db->get();

        return (int)$rez[0][0];
    }
}