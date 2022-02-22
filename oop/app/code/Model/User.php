<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;
use Helper\Logger;

class User extends AbstractModel
{
    private $name;

    private $lastName;

    private $email;

    private $password;

    private $phone;

    private $cityId;

    private $city;

    private $active;

    private $loginAttempts;

    private $createdAt;

    private $roleId;

    public function __construct($id = null)
    {
        $this->table = 'users';
        if ($id !== null){
            $this->load($id);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setLoginAttempts($loginAttempts)
    {
        $this->loginAttempts = $loginAttempts;
    }

    public function getLoginAttempts()
    {
        return $this->loginAttempts;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    public function getAds()
    {
        return Ad::getAllAds($this->id, 'user_id', '=');
    }

    protected function assignData()
    {
        $this->data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId,
            'active' => $this->active,
            'login_attempts' => $this->loginAttempts,
            'role_id' => $this->roleId
        ];
    }

    public function load($id)
    {
        $ads = new Ad();
        $city = new City();
        $db = new DBHelper();

        $data = $db->select()->from($this->table)->where('id', $id)->getOne();

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->lastName = $data['last_name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->phone = $data['phone'];
        $this->cityId = $data['city_id'];
        $this->active = $data['active'];
        $this->loginAttempts = $data['login_attempts'];
        $this->city = $city->load($this->cityId)->getName();
        $this->createdAt = $data['created_at'];
        $this->roleId = $data['role_id'];

        return $this;
    }

    public static function checkLoginCredentials($email, $pass)
    {
        $db = new DBHelper();

        $rez = $db
            ->select('id')
            ->from('users')
            ->where('email', $email)
            ->andWhere('password', $pass)
            ->andWhere('active', 1)
            ->getOne();

        if (isset($rez['id'])) {
            return $rez['id'];
        } else {
            return false;
        }

//        One liner doing the same thing
//        return isset($rez['id']) ? $rez['id'] : false;
    }

    public static function getAllUsers()
    {
        $db = new DBHelper();
        $data = $db->select()->from('users')->get();
        $users = [];

        foreach ($data as $element) {
            $user = new User();
            $user->load($element['id']);
            $users[] = $user;
        }

        return $users;
    }

    public static function getUser($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from('users')->where('id', $id)->get();
        $users = [];

        foreach ($data as $element) {
            $user = new User();
            $user->load($element['id']);
            $users[] = $user;
        }

        return $users;
    }

    public static function getIdByEmail($email)
    {
        $db = new DBHelper();

        $rez = $db
            ->select('id')
            ->from('users')
            ->where('email', $email)
            ->getOne();

        if (isset($rez['id'])) {
            return $rez['id'];
        } else {
            return false;
        }
    }
}