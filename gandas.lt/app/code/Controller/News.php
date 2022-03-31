<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;
use Model\News as NewsModel;

class News extends ControllerAbstract
{
    public function index(): void
    {

        echo 'news/index';

    }

    public function show(string $slug): void
    {

        $news = new NewsModel();

        if ($news->loadBySlug($slug) == null) {

            $error = new Error();
            $error->error404();

            return;

        }

        $this->render('news\single.html', ['news' => $news]);

    }

    public function all(): void
    {

        $data = NewsModel::getAllNews();

        $this->render('news\all.html', ['data' => $data]);

    }
}