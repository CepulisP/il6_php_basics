<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;
use Model\News as NewsModel;
use Model\Collections\News as NewsCollection;

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

        $this->twig->display('news\single.html', ['news' => $news]);

    }

    public function all(): void
    {

        $news = new NewsCollection();

        $news->filter('active', '1');

        $this->twig->display('news\all.html', ['news' => $news->get()]);

    }
}