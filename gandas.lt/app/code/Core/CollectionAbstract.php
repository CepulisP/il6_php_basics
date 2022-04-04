<?php

declare(strict_types=1);

namespace Core;

use Aura\SqlQuery\QueryFactory;

class CollectionAbstract
{
    protected QueryFactory $queryFactory;

    protected DB $db;

    protected \Aura\SqlQuery\Common\SelectInterface $select;

    public function __construct()
    {

        $this->queryFactory = new QueryFactory('mysql');
        $this->db = new DB();

        $this->select = $this->queryFactory->newSelect();
        $this->select->cols(['*'])->from(static::TABLE);

    }

    public function fieldsToSelect(array $fields): CollectionAbstract
    {

        $this->select->cols($fields);

        return $this;

    }

    public function filter(string $field, string $value, string $operator = '='): CollectionAbstract
    {

        $this->select->where("$field $operator :$field");
        $this->select->bindValue($field, $value);

        return $this;

    }
}