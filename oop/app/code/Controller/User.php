<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Validator;
use Model\User as UserModel;
use Model\City;
use Helper\Url;
use Core\AbstractController;

class User extends AbstractController
{
    public function show($id = null)
    {
        $this->data['content'] = '';
        if ($id !== null) {
            $this->data['content'] .= 'User controller ID ' . $id;
        } else {
            $this->data['content'] .= '404 no id';
        }
        $this->render('user/show');
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            $this->logout();
        }

        $form = new FormHelper('user/create/', 'POST');

        $form->input(['name' => 'name', 'type' => 'text', 'placeholder' => 'Name']);
        $form->input(['name' => 'last_name', 'type' => 'text', 'placeholder' => 'Last name']);
        $form->input(['name' => 'phone', 'type' => 'text', 'placeholder' => 'Phone (+370...)']);
        $form->input(['name' => 'email', 'type' => 'email', 'placeholder' => 'name@mail.com']);
        $form->input(['name' => 'password', 'type' => 'password', 'placeholder' => 'Password']);
        $form->input(['name' => 'password2', 'type' => 'password', 'placeholder' => 'Repeat password']);

        $cities = City::getCities();
        $options = [];

        foreach ($cities as $city) {
            $options[$city->getId()] = $city->getName();
        }

        $form->select(['name' => 'city_id', 'options' => $options]);
        $form->input(['name' => 'create', 'type' => 'submit', 'value' => 'Register']);

        $this->data['form'] = $form->getForm();
        $this->render('user/register');
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('user/update/', 'POST');
        $user = new UserModel();

        $user->load($_SESSION['user_id']);

        $form->input([
            'name' => 'name', 'type' => 'text', 'placeholder' => 'Name', 'value' => $user->getName()
        ]);
        $form->input([
            'name' => 'last_name', 'type' => 'text', 'placeholder' => 'Last name', 'value' => $user->getLastName()
        ]);
        $form->input([
            'name' => 'phone', 'type' => 'text', 'placeholder' => 'Phone (+370...)', 'value' => $user->getPhone()
        ]);
        $form->input([
            'name' => 'email', 'type' => 'email', 'placeholder' => 'name@mail.com', 'value' => $user->getEmail()
        ]);
        $form->input([
            'name' => 'password', 'type' => 'password', 'placeholder' => 'New password'
        ]);
        $form->input([
            'name' => 'password2', 'type' => 'password', 'placeholder' => 'Repeat password'
        ]);

        $cities = City::getCities();
        $options = [];

        foreach ($cities as $city) {
            $options[$city->getId()] = $city->getName();
        }

        $form->select(['name' => 'city_id', 'options' => $options, 'selected' => $user->getCityId()]);
        $form->input(['name' => 'edit', 'type' => 'submit', 'value' => 'Save']);

        $this->data['form'] = $form->getForm();
        $this->render('user/edit');
    }

    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->logout();
        }

        $form = new FormHelper('user/check/', 'POST');

        $form->input(['name' => 'email', 'type' => 'email', 'placeholder' => 'name@mail.com']);
        $form->input(['name' => 'password', 'type' => 'password', 'placeholder' => 'Password']);
        $form->input(['name' => 'login', 'type' => 'submit', 'value' => 'Login']);

        $this->data['form'] = $form->getForm();
        $this->render('user/login');
    }

    public function create()
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $emailValid = Validator::checkEmail($_POST['email']);
        $emailUniq = UserModel::emailUniq($_POST['email']);

        if ($passMatch && $emailValid && $emailUniq) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setEmail(strtolower(trim($_POST['email'])));
            $user->setPassword(md5(strtolower(trim($_POST['password']))));
            $user->setPhone($_POST['phone']);
            $user->setCityId($_POST['city_id']);
            $user->setActive(1);
            $user->save();

            Url::redirect('user/login');
        } else {
            echo 'Check email and password';
        }
    }

    public function update()
    {
        $emailValid = Validator::checkEmail($_POST['email']);
        $emailUniq = UserModel::emailUniq($_POST['email']);
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $passSet = !empty($_POST['password']);
        $userId = $_SESSION['user_id'];

        $user = new UserModel();

        $user->load($userId);
        $userEmail = $user->getEmail();
        $inputEmail = strtolower(trim($_POST['email']));

        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setPhone($_POST['phone']);
        $user->setCityId($_POST['city_id']);
        $user->setActive(1);

        if ($emailValid) {
            if ($passMatch) {
                if ($userEmail !== $inputEmail) {
                    if ($emailUniq) {
                        $user->setEmail(strtolower(trim($_POST['email'])));
                    } else {
                        echo 'Email is not unique<br>';
                        echo '<a href="' . BASE_URL . 'user/edit/" style="color:white;">Back to edit</a>';
                        die();
                    }
                }

                if ($passSet) {
                    $user->setPassword(md5(strtolower(trim($_POST['password']))));
                }

                $user->save();
                $user->load($_SESSION['user_id']);
                $_SESSION['user'] = $user;

                Url::redirect('');
            } else {
                echo 'Passwords did not match<br>';
                echo '<a href="' . BASE_URL . 'user/edit/" style="color:white;">Back to edit</a>';
            }
        } else {
            echo 'Email is not valid (must contain "@")';
        }
    }

    public function check()
    {
        $email = strtolower(trim($_POST['email']));
        $password = md5(strtolower(trim($_POST['password'])));

        $userId = UserModel::checkLoginCredentials($email, $password);

        if (!empty($email)) {
            $id = UserModel::getIdByEmail($email);
            if (!empty($id)) {
                $user = new UserModel();
                $user->load($id);
                $loginCount = $user->getLoginAttempts();
                $loginCount++;
                $user->setLoginAttempts($loginCount);
                $user->save();
            }
        }

        if (!empty($user) && $user->getLoginAttempts() <= 5) {
            if ($userId) {
                $user = new UserModel();
                $user->load($userId);
                $user->setLoginAttempts(0);
                $user->save();

                $_SESSION['logged'] = true;
                $_SESSION['user_id'] = $userId;
                $_SESSION['user'] = $user;

                Url::redirect('');
            } else {
                Url::redirect('user/login');
            }
        }else{
            $id = UserModel::getIdByEmail($email);
            $user = new UserModel();
            $user->load($id);
            $user->setActive(0);
            $user->save();
            Url::redirect('user/login');
        }
    }

    public function logout()
    {
        session_destroy();
        Url::redirect('');
    }

    public function all()
    {
        $this->data['users'] = UserModel::getAllUsers();
        $this->render('user/all');
    }
}