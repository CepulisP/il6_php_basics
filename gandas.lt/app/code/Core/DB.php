<?php

declare(strict_types=1);

namespace Core;

class DB
{
    private \PDO $pdo;

    public function __construct()
    {

        try {

            $this->pdo = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {

            echo "Connection failed: " . $e->getMessage();
            die();

        }

    }

    public function get(\Aura\SqlQuery\Common\SelectInterface $sql): ?array
    {

        $sth = $this->pdo->prepare($sql->getStatement());
        $sth->execute($sql->getBindValues());

        if ($rez = $sth->fetch(\PDO::FETCH_ASSOC)) {

            return $rez;

        }

        return null;

    }

    public function getAll(\Aura\SqlQuery\Common\SelectInterface $sql): ?array
    {

        $sth = $this->pdo->prepare($sql->getStatement());
        $sth->execute($sql->getBindValues());

        if ($rez = $sth->fetchAll(\PDO::FETCH_ASSOC)) {

            return $rez;

        }

        return null;

    }
}