<?php

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


class Admin extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->isUserAdmin()){
            Url::redirect('');
        }
    }

    public function index()
    {
        $this->renderAdmin('index');
    }

    public function users()
    {
        $this->data['users'] = UserModel::getAllUsers();
        $this->renderAdmin('users\list');
    }

    public function ads()
    {
        $this->data['ads'] = Ad::getAllAds();
        $this->renderAdmin('ads\list');
    }

    public function adEdit($id)
    {
        $ad = new Ad();
        $ad->load($id, 'id');

        $form = new FormHelper('admin/adupdate', 'POST');

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $id
        ]);

        $form->label('title', 'Title: ', 0);
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

        $form->label('manufacturer_id', 'Manufacturer: ', 0);
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

        $form->label('model_id', 'Model: ', 0);
        $form->select([
            'name' => 'model_id',
            'id' => 'model_id',
            'options' => $options,
            'selected' => $ad->getModelId()
        ]);
        $form->label('price', 'Price: ', 0);
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

        $form->label('year', 'Year: ', 0);
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

        $form->label('type_id', 'Type: ', 0);
        $form->select([
            'name' => 'type_id',
            'id' => 'type_id',
            'options' => $options,
            'selected' => $ad->getTypeId()
        ]);
        $form->label('image', 'Image name: ', 0);
        $form->input([
            'name' => 'image',
            'type' => 'text',
            'id' => 'image',
            'value' => $ad->getImage()
        ]);
        $form->label('active', 'Active (0, 1): ', 0);
        $form->input([
            'name' => 'active',
            'type' => 'text',
            'id' => 'active',
            'value' => $ad->isActive()
        ]);
        $form->label('vin', 'VIN: ', 0);
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

    public function userEdit($id)
    {
        $user = new UserModel();
        $form = new FormHelper('admin/userupdate', 'POST');

        $user->load($id);

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $id
        ]);

        $form->label('name', 'Name: ', 0);
        $form->input([
            'name' => 'name',
            'type' => 'text',
            'id' => 'name',
            'value' => $user->getName()
        ]);
        $form->label('last_name', 'Last name: ', 0);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'id' => 'last_name',
            'value' => $user->getLastName()
        ]);
        $form->label('email', 'Email: ', 0);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'id' => 'email',
            'value' => $user->getEmail()
        ]);
        $form->label('password', 'Password: ', 0);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'New password',
            'id' => 'password'
        ]);
        $form->label('password2', 'Repeat password: ', 0);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'Repeat password',
            'id' => 'password2'
        ]);
        $form->label('phone', 'Phone: ', 0);
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

        $form->label('city', 'City: ', 0);
        $form->select([
            'name' => 'city_id',
            'id' => 'city',
            'options' => $options,
            'selected' => $user->getCityId()
        ]);
        $form->label('active', 'Active (0, 1): ', 0);
        $form->input([
            'name' => 'active',
            'type' => 'text',
            'id' => 'active',
            'value' => $user->isActive()
        ]);
        $form->label('login_attempts', 'Login attempts: ', 0);
        $form->input([
            'name' => 'login_attempts',
            'type' => 'text',
            'id' => 'login_attempts',
            'value' => $user->getLoginAttempts()
        ]);
        $form->label('role_id', 'Role (0, 1): ', 0);
        $form->input([
            'name' => 'role_id',
            'type' => 'text',
            'id' => 'role_id',
            'value' => $user->getRoleId()
        ]);
        $form->input([
            'name' => 'edit',
            'type' => 'submit',
            'value' => 'Save'
        ]);

        $this->data['form'] = $form->getForm();
        $this->renderAdmin('users\edit');
    }

    public function userUpdate()
    {
        $emailValid = Validator::checkEmail($_POST['email']);
        $emailUniq = UserModel::isValueUniq('email', $_POST['email'], 'users');
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $passSet = !empty($_POST['password']);
        $userId = $_POST['id'];

        $user = new UserModel();

        $user->load($userId);
        $userEmail = $user->getEmail();
        $inputEmail = strtolower(trim($_POST['email']));

        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setPhone($_POST['phone']);
        $user->setCityId($_POST['city_id']);
        $user->setActive($_POST['active']);
        $user->setLoginAttempts($_POST['login_attempts']);
        $user->setRoleId($_POST['role_id']);

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

                if ($passSet) {
                    $user->setPassword(md5(strtolower(trim($_POST['password']))));
                }

                $user->save();

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

    public function adUpdate()
    {
        $adId = $_POST['id'];

        $ad = new Ad();

        $ad->load($adId, 'id');

        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setImage($_POST['image']);
        $ad->setActive($_POST['active']);
        $ad->setVin($_POST['vin']);
        $ad->save();

        Url::redirect('admin/ads');
    }
}