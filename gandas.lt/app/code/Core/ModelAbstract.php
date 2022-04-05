<?php

declare(strict_types=1);

namespace Core;

use Aura\SqlQuery\QueryFactory;

class ModelAbstract
{
    protected const TABLE = '';

    protected QueryFactory $queryFactory;

    protected DB $db;

    protected array $data;

    protected int $id;

    public function __construct()
    {

        $this->queryFactory = new QueryFactory('mysql');
        $this->db = new DB();

    }

    public function getId(): int
    {

        return $this->id;

    }

    protected function assignData(): void
    {

        $this->data = [];

    }

    public function save(): void
    {
        $this->assignData();

        if (!isset($this->id)) {

            $this->create();

        } else {

            $this->edit();

        }
    }

    protected function create(): void
    {

        $insert = $this->insert();
        $insert->into(static::TABLE)->cols($this->data);
        $this->db->execInsert($insert);

    }

    protected function edit(): void
    {

        $update = $this->update();
        $update->table(static::TABLE)->cols($this->data);
        $this->db->execUpdate($update);

    }

    protected function select(): \Aura\SqlQuery\Common\SelectInterface
    {

        return $this->queryFactory->newSelect();

    }

    protected function insert(): \Aura\SqlQuery\Common\InsertInterface
    {

        return $this->queryFactory->newInsert();

    }

    protected function update(): \Aura\SqlQuery\Common\UpdateInterface
    {

        return $this->queryFactory->newUpdate();

    }

    protected function delete(): \Aura\SqlQuery\Common\DeleteInterface
    {

        return $this->queryFactory->newDelete();

    }

    public static function isValueUniq(string $field, string $value): bool
    {

        $queryFactory = new QueryFactory('mysql');
        $db = new DB();
        $value = strtolower(trim($value));

        $select = $queryFactory->newSelect();
        $select->cols(['id'])->from(static::TABLE)->where("$field = :$field");
        $select->bindValue($field, $value);

        return empty($db->getAll($select));

    }
}