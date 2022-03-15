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

    protected const ITEMS_PER_PAGE = 10;

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

    protected function pageForm(object $form, int $itemCount): void
    {
        $itemsPerPage = !empty($_GET['show']) ? $_GET['show'] : static::ITEMS_PER_PAGE;

        $itemsPerPageSelect = [
            'name' => 'show',
            'id' => 'show',
            'selected' => $itemsPerPage,
            'options' => [
                '5' => '5',
                '10' => '10',
                '20' => '20',
                '50' => '50',
                '100' => '100'
            ]
        ];

        $pageCount = ceil($itemCount / $itemsPerPage);
        $options = [];

        for ($i = 1; $i <= $pageCount; $i++) {
            $options[$i] = $i;
        }

        $pageSelect = [
            'name' => 'p',
            'id' => 'page',
            'selected' => 1,
            'options' => $options
        ];

        if (!empty($_GET['p'])) $pageSelect['selected'] = $_GET['p'];

        $form->label('show', ' Show per page: ', false);
        $form->select($itemsPerPageSelect, false);
        $form->label('page', ' Page: ', false);
        $form->select($pageSelect);
    }

    public function pageSplice(array $data): array
    {
        $page = !empty($_GET['p']) ? (int)$_GET['p'] : 1;
        $itemsPerPage = !empty($_GET['show']) ? (int)$_GET['show'] : static::ITEMS_PER_PAGE;
        $firstItem = ($page - 1) * $itemsPerPage;
        return array_splice($data, $firstItem, $itemsPerPage);
    }
}