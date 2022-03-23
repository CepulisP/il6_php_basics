<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\Logger;
use Helper\Url;

class User extends AbstractModel implements ModelInterface
{
    private string $name;

    private string $lastName;

    private string $nickname;

    private string $email;

    private string $password;

    private string $phone;

    private int $cityId;

    private string $city;

    private int $active;

    private int $loginAttempts;

    private string $createdAt;

    private int $roleId;

    protected const TABLE = 'users';

    public function __construct(?int $id = null)
    {
        if ($id !== null) {
            $this->load($id);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function setCityId(int $cityId): void
    {
        $this->cityId = $cityId;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function isActive(): int
    {
        return $this->active;
    }

    public function setLoginAttempts(int $loginAttempts): void
    {
        $this->loginAttempts = $loginAttempts;
    }

    public function getLoginAttempts(): int
    {
        return $this->loginAttempts;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }

    public function getAds(
        ?bool $activeOnly = null,
        ?int $limit = null,
        ?int $offset = null
    ): array
    {
        return Ad::getUserAds($this->id, $activeOnly, $limit, $offset);
    }

    public function assignData(): void
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

    public function load(int $id): ?User
    {
        $city = new City();
        $db = new DBHelper();

        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($data)) {
            $this->id = (int)$data['id'];
            $this->name = $data['name'];
            $this->lastName = $data['last_name'];
            $this->nickname = $data['nickname'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->phone = $data['phone'];
            $this->cityId = (int)$data['city_id'];
            $this->active = (int)$data['active'];
            $this->loginAttempts = (int)$data['login_attempts'];
            $this->city = $city->load($this->cityId)->getName();
            $this->createdAt = $data['created_at'];
            $this->roleId = (int)$data['role_id'];

            return $this;
        }
        return null;
    }

    public static function checkLoginCredentials(string $email, string $pass): ?int
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
            return (int)$rez['id'];
        } else {
            return null;
        }

//        One liner doing the same thing
//        return isset($rez['id']) ? $rez['id'] : false;
    }

    public static function getAllUsers(
        bool $activeOnly = true,
        ?int $limit = null,
        ?int $offset = null
    ): array
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
            $user = new User((int)$element['id']);
            $users[] = $user;
        }

        return $users;
    }

    public static function getUsers(array $ids): array
    {
        $users = [];
        foreach ($ids as $id){
            $users[] = new User((int)$id);
        }
        return $users;
    }

    public static function getIdByEmail(string $email): ?int
    {
        $db = new DBHelper();

        $rez = $db
            ->select('id')
            ->from(self::TABLE)
            ->where('email', $email)
            ->getOne();

        return (int)$rez['id'] ?? null;
    }

    public static function getIdByNickname(string $nick): ?int
    {
        $db = new DBHelper();

        $rez = $db
            ->select('id')
            ->from(self::TABLE)
            ->where('nickname', $nick)
            ->getOne();

        return (int)$rez['id'] ?? null;
    }

    public static function getNicknameById(int $id): string
    {
        $user = new User($id);
        return $user->getNickname();
    }

    public static function getSavedAdUsersIds(int $adId): array
    {
        $users = SavedAd::getSavedAdUsers($adId);
        $savedUsers = [];
        foreach ($users as $user){
            $savedUser = new User((int)$user['user_id']);
            if ($savedUser->isActive()){
                $savedUsers[] = $savedUser->getId();
            }
        }
        return $savedUsers;
    }
}