<?php

declare(strict_types=1);

namespace Controller;

use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Logger;
use Helper\Validator;
use Model\User as UserModel;
use Model\City;
use Helper\Url;
use Core\AbstractController;

class User extends AbstractController implements ControllerInterface
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) Url::redirect('user/login');
        $this->render('user/index');
    }

    public function register(): void
    {
        if (isset($_SESSION['user_id'])) $this->logout();

        $form = new FormHelper('user/create/', 'POST');

        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Name'
        ]);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Last name'
        ]);
        $form->input([
            'name' => 'nickname',
            'type' => 'text',
            'placeholder' => 'Nickname'
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'name@mail.com'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'Repeat password'
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => 'Phone (+370...)'
        ]);

        $cities = City::getCities();
        $options = [];

        foreach ($cities as $city) {
            $options[$city->getId()] = $city->getName();
        }

        $form->select([
            'name' => 'city_id',
            'options' => $options
        ]);
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Register'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/register');
    }

    public function edit(): void
    {
        if (!isset($_SESSION['user_id'])) Url::redirect('user/login');

        $form = new FormHelper('user/update/', 'POST');
        $user = new UserModel((int)$_SESSION['user_id']);

        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Name',
            'value' => $user->getName()
        ]);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Last name',
            'value' => $user->getLastName()
        ]);
        $form->input([
            'name' => 'nickname',
            'type' => 'text',
            'placeholder' => 'Nickname',
            'value' => $user->getNickname()
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'name@mail.com',
            'value' => $user->getEmail()
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'New password'
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'Repeat password'
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => 'Phone (+370...)',
            'value' => $user->getPhone()
        ]);

        $cities = City::getCities();
        $options = [];

        foreach ($cities as $city) {
            $options[$city->getId()] = $city->getName();
        }

        $form->select([
            'name' => 'city_id',
            'options' => $options,
            'selected' => $user->getCityId()
        ]);
        $form->input([
            'name' => 'edit',
            'type' => 'submit',
            'value' => 'Save'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/edit');
    }

    public function login(): void
    {
        if (isset($_SESSION['user_id'])) $this->logout();

        $form = new FormHelper('user/check/', 'POST');

        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'name@mail.com'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'login',
            'type' => 'submit',
            'value' => 'Login'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/login');
    }

    public function create(): void
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $emailValid = Validator::checkEmail($_POST['email']);
        $emailUniq = UserModel::isValueUniq('email', $_POST['email']);
        $nickUniq = UserModel::isValueUniq('nickname', $_POST['nickname']);

        if ($passMatch && $emailValid && $emailUniq && $nickUniq) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setNickname(trim($_POST['nickname']));
            $user->setEmail(strtolower(trim($_POST['email'])));
            $user->setPassword(md5(strtolower(trim($_POST['password']))));
            $user->setPhone($_POST['phone']);
            $user->setCityId((int)$_POST['city_id']);
            $user->setActive(1);
            $user->setLoginAttempts(0);
            $user->setRoleId(0);
            $user->save();

            unset($_SESSION['register_error']);
            Url::redirect('user/login');
        } else {
            $_SESSION['register_error'] = 'Error: Email/Nickname taken or passwords didn\'t match';
            Url::redirect('user/register');
        }
    }

    public function update(): void
    {
        $emailValid = Validator::checkEmail($_POST['email']);
        $emailUniq = UserModel::isValueUniq('email', $_POST['email']);
        $nickUniq = UserModel::isValueUniq('nickname', $_POST['nickname']);
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $passSet = !empty($_POST['password']);
        $userId = $_SESSION['user_id'];

        $user = new UserModel((int)$userId);

        $userEmail = $user->getEmail();
        $inputEmail = strtolower(trim($_POST['email']));
        $userNick = $user->getNickname();
        $inputNick = strtolower(trim($_POST['nickname']));

        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setPhone($_POST['phone']);
        $user->setCityId((int)$_POST['city_id']);
        $user->setActive(1);

        if ($emailValid) {
            if ($passMatch) {
                if ($userEmail !== $inputEmail) {
                    if ($emailUniq) {
                        $user->setEmail(strtolower(trim($_POST['email'])));
                    } else {
                        $_SESSION['edit_error'] = 'Email is not unique';
                        Url::redirect('user/edit');
                    }
                }

                if ($userNick !== $inputNick) {
                    if ($nickUniq) {
                        $user->setNickname(trim($_POST['nickname']));
                    } else {
                        $_SESSION['edit_error'] = 'Nickname is not unique';
                        Url::redirect('user/edit');
                    }
                }

                if ($passSet) $user->setPassword(md5(strtolower(trim($_POST['password']))));

                $user->save();
                $user->load((int)$_SESSION['user_id']);
                $_SESSION['user'] = $user;

                unset($_SESSION['edit_error']);
                Url::redirect('');
            } else {
                $_SESSION['edit_error'] = 'Passwords did not match';
                Url::redirect('user/edit');
            }
        } else {
            $_SESSION['edit_error'] = 'Email is not valid (must contain "@")';
            Url::redirect('user/edit');
        }
    }

    public function check(): void
    {
        $email = strtolower(trim($_POST['email']));
        $password = md5(strtolower(trim($_POST['password'])));

        $userId = UserModel::checkLoginCredentials($email, $password);

        if (!empty($email)) {
            $id = UserModel::getIdByEmail($email);
            if (!empty($id)) {
                $user = new UserModel($id);
                $loginCount = $user->getLoginAttempts();
                $loginCount++;
                $user->setLoginAttempts($loginCount);

                if ($user->isActive()) {
                    if ($loginCount > 5) {
                        $user->setActive(0);
                        $user->save();
                        $_SESSION['login_error'] = 'Too many attempts, user is now locked';

                    }
                }else{
                    $_SESSION['login_error'] = 'User is locked';
                    Url::redirect('user/login');
                }

                $user->save();
            }
        }

        if (!empty($userId)) {
            $user = new UserModel($userId);
            $user->setLoginAttempts(0);
            $user->save();

            session_destroy();
            session_start();

            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['user'] = $user;

            Url::redirect('');
        } else {
            Url::redirect('user/login');
        }
    }

    public function logout(): void
    {
        session_destroy();
        Url::redirect('');
    }
}