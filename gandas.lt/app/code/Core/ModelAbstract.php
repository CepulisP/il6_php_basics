<?php

declare(strict_types=1);

namespace Core;

use Aura\SqlQuery\QueryFactory;

class ModelAbstract
{
    protected QueryFactory $queryFactory;

    protected DB $db;

    public function __construct()
    {

        $this->queryFactory = new QueryFactory('mysql');
        $this->db = new DB();

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
}