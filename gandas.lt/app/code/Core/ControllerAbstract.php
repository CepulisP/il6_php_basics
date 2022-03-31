<?php

declare(strict_types=1);

namespace Core;

class ControllerAbstract
{
    protected \Twig\Environment $twig;

    public function __construct()
    {

        $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '\app\templates');
        $this->twig = new \Twig\Environment($loader, [
//            'cache' => PROJECT_ROOT . '\var\compilation_cache'
            'cache' => false
        ]);

    }

    protected function render(string $template, ?array $variables = []): void
    {

        $this->twig->display('parts\header.html');
        $this->twig->display($template, $variables);
        $this->twig->display('parts\footer.html');

    }
}