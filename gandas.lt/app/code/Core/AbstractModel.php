<?php

declare(strict_types=1);

namespace Core;

use Aura\SqlQuery\QueryFactory;

class AbstractModel
{
    protected QueryFactory $queryFactory;

    public function __construct()
    {

        $queryFactory = new QueryFactory('mysql');

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