<?php

declare(strict_types=1);

namespace Model\Collections;

use Core\CollectionAbstract;
use Model\News as NewsModel;

class News extends CollectionAbstract
{
    const TABLE = 'news';

    public function get(): ?array
    {

        $rez = $this->db->getAll($this->select);
        $news = [];

        if (!empty($rez)) {

            foreach ($rez as $element) {

                $new = new NewsModel();
                $news[] = $new->load((int) $element['id']);

            }

            return $news;
        }

        return null;

    }

    public function getArray(): ?array
    {

        return $this->db->getAll($this->select) ?? null;

    }
}