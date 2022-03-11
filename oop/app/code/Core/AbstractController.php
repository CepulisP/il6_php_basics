<?php

declare(strict_types=1);

namespace Core;

use Helper\Url;
use Model\Ad;
use Model\Message;
use Model\User as UserModel;
use Helper\Logger;

class AbstractController
{
    protected array $data;

    public function __construct()
    {
        $this->data = [];
        $this->data['title'] = 'AutoMarket | Auto ad portal';
        $this->data['meta_description'] = '';
    }

    protected function render($template): void
    {
        include_once PROJECT_ROOT_DIR . '\app\design\parts\header.php';
        include_once PROJECT_ROOT_DIR . '\app\design\\' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '\app\design\parts\footer.php';
    }

    protected function renderAdmin($template): void
    {
        include_once PROJECT_ROOT_DIR . '\app\design\admin\parts\header.php';
        include_once PROJECT_ROOT_DIR . '\app\design\admin\\' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '\app\design\admin\parts\footer.php';
    }

    protected function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function link(string $path, ?string $param = null): string
    {
        return Url::link($path, $param);
    }

    protected function isUserAdmin(): bool
    {
        if ($this->isUserLoggedIn() && $_SESSION['user']->getRoleId() == 1){
            return true;
        }
        return false;
    }

    public function getNewMessageCount(?int $senderId = null): int
    {
        return Message::countNewMessages((int)$_SESSION['user_id'], $senderId);
    }
}