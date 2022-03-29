<?php

declare(strict_types=1);

namespace Controller;

class News
{
    public function index(): void
    {
        echo 'news/index';
    }

    public function show(string $slug): void
    {
        echo 'news/' . $slug;
    }
}