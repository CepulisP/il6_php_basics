<?php

namespace Core;

use Helper\Url;
use Model\User as UserModel;
use Helper\Logger;

class AbstractController
{
    protected $data;

    public function __construct()
    {
        $this->data = [];
        $this->data['title'] = 'Auto-Market | Auto ad portal';
        $this->data['meta_description'] = '';
    }

    protected function render($template)
    {
        include_once PROJECT_ROOT_DIR . '\app\design\parts\header.php';
        include_once PROJECT_ROOT_DIR . '\app\design\\' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '\app\design\parts\footer.php';
    }

    protected function renderAdmin($template)
    {
        include_once PROJECT_ROOT_DIR . '\app\design\admin\parts\header.php';
        include_once PROJECT_ROOT_DIR . '\app\design\admin\\' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '\app\design\admin\parts\footer.php';
    }

    protected function isUserLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function link($path, $param = null)
    {
        return Url::link($path, $param);
    }

    protected function isUserAdmin()
    {
        if ($this->isUserLoggedIn() && $_SESSION['user']->getRoleId() == 1){
            return true;
        }
        return false;
    }
}