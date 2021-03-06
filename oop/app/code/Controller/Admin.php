<?php

declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Logger;
use Helper\Url;
use Model\Model;
use Model\User as UserModel;
use Model\Ad;
use Model\City;
use Model\Manufacturer;
use Model\Type;
use Helper\Validator;
use Core\Interfaces\ControllerInterface;


class Admin extends AbstractController implements ControllerInterface
{
    public const NOT_ACTIVE = 0;

    public const ACTIVE = 1;

    public const DELETE = 2;

    protected const ITEMS_PER_PAGE = 10;

    public function __construct()
    {
        parent::__construct();

        if (!$this->isUserAdmin()) Url::redirect('');
    }

    public function index(): void
    {
        $this->renderAdmin('index');
    }

    public function users(): void
    {
        $users = UserModel::getAllUsers(false);
        $form = new FormHelper('admin/users', 'GET');

        $this->pageForm($form, count($users));

        $form->input([
            'type' => 'submit',
            'value' => 'Enter'
        ]);

        $this->data['form'] = $form->getForm();
        $this->data['users'] = $this->pageSplice($users);
        $this->renderAdmin('users\list');
    }

    public function ads(): void
    {
        $ads = Ad::getAllAds(false);
        $form = new FormHelper('admin/ads', 'GET');

        $this->pageForm($form, count($ads));

        $form->input([
            'type' => 'submit',
            'value' => 'Enter'
        ]);

        $this->data['form'] = $form->getForm();
        $this->data['ads'] = $this->pageSplice($ads);
        $this->renderAdmin('ads\list');
    }

    public function adEdit(int $id): void
    {
        $ad = new Ad($id);

        $form = new FormHelper('admin/adupdate', 'POST');

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $id
        ]);

        $form->label('title', 'Title: ', false);
        $form->input([
            'name' => 'title',
            'type' => 'text',
            'id' => 'title',
            'value' => $ad->getTitle()
        ]);
        $form->label('description', 'Description: ');
        $form->textArea('description', $ad->getDescription(), 'description');

        $manufacturers = Manufacturer::getManufacturers();
        $options = [];

        foreach ($manufacturers as $manufacturer) {
            $options[$manufacturer->getId()] = $manufacturer->getName();
        }

        $form->label('manufacturer_id', 'Manufacturer: ', false);
        $form->select([
            'name' => 'manufacturer_id',
            'id' => 'manufacturer_id',
            'options' => $options,
            'selected' => $ad->getManufacturerId()
        ]);

        $models = Model::getModels();
        $options = [];

        foreach ($models as $model) {
            $options[$model->getId()] = $model->getName();
        }

        $form->label('model_id', 'Model: ', false);
        $form->select([
            'name' => 'model_id',
            'id' => 'model_id',
            'options' => $options,
            'selected' => $ad->getModelId()
        ]);
        $form->label('price', 'Price: ', false);
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'step' => '0.01',
            'id' => 'price',
            'value' => $ad->getPrice()
        ]);

        $options = [];

        for ($i = 1990; $i <= date('Y'); $i++) {
            $options[$i] = $i;
        }

        $form->label('year', 'Year: ', false);
        $form->select([
            'name' => 'year',
            'id' => 'year',
            'options' => $options,
            'selected' => $ad->getYear()
        ]);

        $types = Type::getTypes();
        $options = [];

        foreach ($types as $type) {
            $options[$type->getId()] = $type->getName();
        }

        $form->label('type_id', 'Type: ', false);
        $form->select([
            'name' => 'type_id',
            'id' => 'type_id',
            'options' => $options,
            'selected' => $ad->getTypeId()
        ]);
        $form->label('image', 'Image url: ', false);
        $form->input([
            'name' => 'image',
            'type' => 'text',
            'id' => 'image',
            'value' => $ad->getImage()
        ]);
        $form->label('active', 'Active: ', false);
        $form->select([
            'name' => 'active',
            'id' => 'active',
            'selected' => $ad->isActive(),
            'options' => [
                '0' => 'Inactive',
                '1' => 'Active'
            ]
        ]);
        $form->label('vin', 'VIN: ', false);
        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'id' => 'vin',
            'value' => $ad->getVin()
        ]);
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Save'
        ]);

        $this->data['form'] = $form->getForm();
        $this->renderAdmin('ads\edit');
    }

    public function userEdit(int $id): void
    {
        $user = new UserModel($id);
        $form = new FormHelper('admin/userupdate', 'POST');

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $id
        ]);

        $form->label('name', 'Name: ', false);
        $form->input([
            'name' => 'name',
            'type' => 'text',
            'id' => 'name',
            'value' => $user->getName()
        ]);
        $form->label('last_name', 'Last name: ', false);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'id' => 'last_name',
            'value' => $user->getLastName()
        ]);
        $form->label('email', 'Email: ', false);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'id' => 'email',
            'value' => $user->getEmail()
        ]);
        $form->label('password', 'Password: ', false);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'New password',
            'id' => 'password'
        ]);
        $form->label('password2', 'Repeat password: ', false);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'Repeat password',
            'id' => 'password2'
        ]);
        $form->label('phone', 'Phone: ', false);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'id' => 'phone',
            'value' => $user->getPhone()
        ]);

        $cities = City::getCities();
        $options = [];

        foreach ($cities as $city) {
            $options[$city->getId()] = $city->getName();
        }

        $form->label('city', 'City: ', false);
        $form->select([
            'name' => 'city_id',
            'id' => 'city',
            'options' => $options,
            'selected' => $user->getCityId()
        ]);
        $form->label('active', 'Active: ', false);
        $form->select([
            'name' => 'active',
            'id' => 'active',
            'selected' => $user->isActive(),
            'options' => [
                '0' => 'Inactive',
                '1' => 'Active'
            ]
        ]);
        $form->label('login_attempts', 'Login attempts: ', false);
        $form->input([
            'name' => 'login_attempts',
            'type' => 'text',
            'id' => 'login_attempts',
            'value' => $user->getLoginAttempts()
        ]);
        $form->label('role_id', 'Role: ', false);
        $form->select([
            'name' => 'role_id',
            'id' => 'role_id',
            'selected' => $user->getRoleId(),
            'options' => [
                '0' => 'Basic',
                '1' => 'Admin'
            ]
        ]);
        $form->input([
            'name' => 'edit',
            'type' => 'submit',
            'value' => 'Save'
        ]);

        $this->data['form'] = $form->getForm();
        $this->renderAdmin('users\edit');
    }

    public function userUpdate(): void
    {
        $emailValid = Validator::checkEmail($_POST['email']);
        $emailUniq = UserModel::isValueUniq('email', $_POST['email']);
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $passSet = !empty($_POST['password']);
        $userId = $_POST['id'];

        $user = new UserModel((int)$userId);

        $userEmail = $user->getEmail();
        $inputEmail = strtolower(trim($_POST['email']));

        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setPhone($_POST['phone']);
        $user->setCityId((int)$_POST['city_id']);
        $user->setActive((int)$_POST['active']);
        $user->setLoginAttempts((int)$_POST['login_attempts']);
        $user->setRoleId((int)$_POST['role_id']);

        if ($emailValid) {
            if ($passMatch) {
                if ($userEmail !== $inputEmail) {
                    if ($emailUniq) {
                        $user->setEmail(strtolower(trim($_POST['email'])));
                    } else {
                        $_SESSION['admin_edit_error'] = 'Email is not unique';
                        Url::redirect('admin/useredit/'.$userId);
                    }
                }

                if ($passSet) $user->setPassword(md5(strtolower(trim($_POST['password']))));

                $user->save();

                unset($_SESSION['admin_edit_error']);
                Url::redirect('admin/users');
            } else {
                $_SESSION['admin_edit_error'] = 'Passwords did not match';
                Url::redirect('admin/useredit/'.$userId);
            }
        } else {
            $_SESSION['admin_edit_error'] = 'Email is not valid (must contain "@")';
            Url::redirect('admin/useredit/'.$userId);
        }
    }

    public function adUpdate(): void
    {
        $ad = new Ad((int)$_POST['id']);

        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId((int)$_POST['manufacturer_id']);
        $ad->setModelId((int)$_POST['model_id']);
        $ad->setPrice((float)$_POST['price']);
        $ad->setYear((int)$_POST['year']);
        $ad->setTypeId((int)$_POST['type_id']);
        $ad->setImage($_POST['image']);
        $ad->setActive((int)$_POST['active']);
        $ad->setVin($_POST['vin']);
        $ad->save();

        Url::redirect('admin/ads');
    }

    public function massUserUpdate(): void
    {
        if (!isset($_POST['selected'])) Url::redirect('admin/users');

        $action = $_POST['action'];
        $ids = $_POST['selected'];

        if ($action == self::ACTIVE || self::NOT_ACTIVE){
            foreach ($ids as $id){
                $ad = new UserModel((int)$id);
                $ad->setActive((int)$action);
                $ad->save();
            }
        }elseif ($action == self::DELETE){
            foreach ($ids as $id){
                $ad = new UserModel((int)$id);
                $ad->delete();
            }
        }

        Url::redirect('admin/users');
    }

    public function massAdUpdate(): void
    {
        if (!isset($_POST['selected'])) Url::redirect('admin/ads');

        $action = $_POST['action'];
        $ids = $_POST['selected'];

        if ($action == self::ACTIVE || self::NOT_ACTIVE){
            foreach ($ids as $id){
                $ad = new Ad((int)$id);
                $ad->setActive((int)$action);
                $ad->save();
            }
        }elseif ($action == self::DELETE){
            foreach ($ids as $id){
                $ad = new Ad((int)$id);
                $ad->delete();
            }
        }

        Url::redirect('admin/ads');
    }
}