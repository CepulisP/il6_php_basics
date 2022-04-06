<?php

declare(strict_types=1);

namespace Controller;

use Core\ControllerAbstract;
use Helper\Checker;
use Helper\UrlHelper;
use Model\Account;

class User extends ControllerAbstract
{
    public function index(): void
    {
        echo 'user/index';
    }

    public function register(): void
    {

        if (isset($_SESSION['user_id'])) $this->logout();

        $this->twig->display('user\register.html', ['online' => $this->isUserLoggedIn()]);

    }

    public function edit(): void
    {

        if (!isset($_SESSION['user_id'])) UrlHelper::redirect('user/login');

        $user = new Account((int) $_SESSION['user_id']);

        $this->twig->display('user\edit.html', ['user' => $user, 'online' => $this->isUserLoggedIn()]);

    }

    public function login(): void
    {

        if (isset($_SESSION['user_id'])) $this->logout();

        $this->twig->display('user\login.html', ['online' => $this->isUserLoggedIn()]);

    }

    public function execRegister(): void
    {

        $passMatch = Checker::checkPassword($_POST['password'], $_POST['password2']);
        $emailValid = Checker::checkEmail($_POST['email']);
        $emailUniq = Account::isValueUniq('email', $_POST['email']);
        $nickUniq = Account::isValueUniq('nickname', $_POST['nickname']);

        if ($passMatch && $emailValid && $emailUniq && $nickUniq) {

            $user = new Account();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setNickname(trim($_POST['nickname']));
            $user->setEmail(strtolower(trim($_POST['email'])));
            $user->setPassword(md5(strtolower(trim($_POST['password']))));
            $user->setActive(1);
            $user->setRoleId(3);
            $user->save();

            UrlHelper::redirect('user/login');

        } else {

            UrlHelper::redirect('user/register');

        }

    }

    public function execEdit(): void
    {

        if (!isset($_SESSION['user_id'])) UrlHelper::redirect('user/login');

        $emailValid = Checker::checkEmail($_POST['email']);
        $passMatch = Checker::checkPassword($_POST['password'], $_POST['password2']);
        $emailUniq = Account::isValueUniq('email', $_POST['email']);
        $nickUniq = Account::isValueUniq('nickname', $_POST['nickname']);
        $passSet = !empty($_POST['password']);
        $userId = $_SESSION['user_id'];

        $user = new Account((int)$userId);

        $userEmail = $user->getEmail();
        $inputEmail = strtolower(trim($_POST['email']));
        $userNick = $user->getNickname();
        $inputNick = strtolower(trim($_POST['nickname']));

        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);

        if ($emailValid && $passMatch) {

            if ($userEmail !== $inputEmail) {

                if ($emailUniq) {

                    $user->setEmail(strtolower(trim($_POST['email'])));

                } else {

                    UrlHelper::redirect('user/edit');

                }
            }

            if ($userNick !== $inputNick) {

                if ($nickUniq) {

                    $user->setNickname(trim($_POST['nickname']));

                } else {

                    UrlHelper::redirect('user/edit');

                }

            }

            if ($passSet) $user->setPassword(md5(strtolower(trim($_POST['password']))));

            $user->save();

            UrlHelper::redirect('');

        } else {

            UrlHelper::redirect('user/edit');

        }

    }

    public function execLogin(): void
    {

        $email = strtolower(trim($_POST['email']));
        $password = md5(strtolower(trim($_POST['password'])));
        $userId = Account::checkLoginCredentials($email, $password);

        if ($userId != null) {

            $_SESSION['user_id'] = $userId;

            UrlHelper::redirect('');

        } else {

            UrlHelper::redirect('user/login');

        }

    }

    public function logout(): void
    {

        session_destroy();
        UrlHelper::redirect('');

    }
}