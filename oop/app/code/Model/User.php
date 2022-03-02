<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\Logger;
use Helper\Url;

class User extends AbstractModel implements ModelInterface
{
    private $name;

    private $lastName;

    private $nickname;

    private $email;

    private $password;

    private $phone;

    private $cityId;

    private $city;

    private $active;

    private $loginAttempts;

    private $createdAt;

    private $roleId;

    protected const TABLE = 'users';

    public function __construct($id = null)
    {
        if ($id !== null) {
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

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
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

    public function getAds(
        $activeOnly = null,
        $limit = null,
        $offset = null
    )
    {
        return Ad::getUserAds($this->id, $activeOnly, $limit, $offset);
    }

    public function assignData()
    {
        $this->data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'nickname' => $this->nickname,
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

        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->lastName = $data['last_name'];
        $this->nickname = $data['nickname'];
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
            ->from(self::TABLE)
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

    public static function getAllUsers(
        $activeOnly = true,
        $limit = null,
        $offset = null
    )
    {
        $db = new DBHelper();
        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $users = [];

        foreach ($data as $element) {
            $user = new User($element['id']);
            $users[] = $user;
        }

        return $users;
    }

    public static function getIdByEmail($email)
    {
        $db = new DBHelper();

        $rez = $db
            ->select('id')
            ->from(self::TABLE)
            ->where('email', $email)
            ->getOne();

        return $rez['id'] ?? false;
    }

    public static function getIdByNickname($nick)
    {
        $db = new DBHelper();

        $rez = $db
            ->select('id')
            ->from(self::TABLE)
            ->where('nickname', $nick)
            ->getOne();

        return $rez['id'] ?? false;
    }

    public static function getNicknameById($id)
    {
        $user = new User($id);
        return $user->getNickname();
    }
}