<?php

declare(strict_types=1);

namespace Model;

use Aura\SqlQuery\QueryFactory;
use Core\DB;
use Core\ModelAbstract;

class Account extends ModelAbstract
{
    protected const TABLE = 'users';

    private string $name;

    private string $lastName;

    private string $email;

    private string $password;

    private int $roleId;

    private string $nickName;

    private int $active;

    private string $createdAt;

    public function __construct(?int $id = null)
    {

        parent::__construct();

        if ($id !== null) {

            $this->load($id);

        }

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->roleId;
    }

    /**
     * @param int $roliId
     */
    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nickName;
    }

    /**
     * @param string $nickName
     */
    public function setNickName(string $nickName): void
    {
        $this->nickName = $nickName;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    protected function assignData(): void
    {

        $this->data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->roleId,
            'nickname' => $this->nickName,
            'active' => $this->active
        ];

    }

    public function load(int $id): ?Account
    {

        $sql = $this->select();
        $sql->cols(['*'])->from('users')->where('id = :id')->bindValue('id', $id);

        if ($rez = $this->db->get($sql)) {

            $this->id = (int) $rez['id'];
            $this->name = $rez['name'];
            $this->lastName = $rez['last_name'];
            $this->email = $rez['email'];
            $this->password = $rez['password'];
            $this->roleId = (int) $rez['role_id'];
            $this->nickName = $rez['nickname'];
            $this->active = (int) $rez['active'];
            $this->createdAt = $rez['created_at'];

            return $this;

        }

        return null;

    }

    public static function checkLoginCredentials(string $email, string $pass): ?int
    {
        $queryFactory = new QueryFactory('mysql');
        $db = new DB();

        $select = $queryFactory->newSelect();
        $select->cols(['id'])->from(self::TABLE)->where('email = :email')->where('password = :password');
        $select->bindValues(['email' => $email, 'password' => $pass]);

        $rez = $db->get($select);
        
        return (int) $rez['id'] ?? null;
    }

}