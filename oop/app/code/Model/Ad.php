<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\Logger;

class Ad extends AbstractModel implements ModelInterface
{
    private string $title;

    private string $description;

    private int $manufacturerId;

    private string $manufacturer;

    private int $modelId;

    private string $model;

    private float $price;

    private int $year;

    private int $typeId;

    private string $type;

    private int $userId;

    private string $image;

    private int $active;

    private string $slug;

    private string $createdAt;

    private string $vin;

    private int $views;

    protected const TABLE = 'ads';

    public function __construct(?int $id = null)
    {
        if ($id !== null) {
            $this->load($id);
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getManufacturerId(): int
    {
        return $this->manufacturerId;
    }

    public function setManufacturerId(int $manufacturerId): void
    {
        $this->manufacturerId = $manufacturerId;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getModelId(): int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): void
    {
        $this->modelId = $modelId;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getTypeId(): int
    {
        return $this->typeId;
    }

    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function isActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function setVin(string $vin): void
    {
        $this->vin = $vin;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): void
    {
        $this->views = $views;
    }

    public function getUser(): User
    {
        return new User($this->userId);
    }

    public function getComments(?int $limit = null): array
    {
        return Comment::getAdComments($this->id, $limit);
    }

    public function getRating(): float
    {
        return Rating::getAdRating($this->id);
    }

    public function assignData(): void
    {
        $this->data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturerId,
            'model_id' => $this->modelId,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->typeId,
            'user_id' => $this->userId,
            'image' => $this->image,
            'active' => $this->active,
            'slug' => $this->slug,
            'vin' => $this->vin,
            'views' => $this->views
        ];
    }

    public function load(int $id): Ad
    {
        $man = new Manufacturer();
        $model = new Model();
        $type = new Type();
        $db = new DBHelper();

        $ad = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($ad)) {
            $this->id = (int)$ad['id'];
            $this->title = $ad['title'];
            $this->description = $ad['description'];
            $this->manufacturerId = (int)$ad['manufacturer_id'];
            $this->manufacturer = $man->load($this->manufacturerId)->getName();
            $this->modelId = (int)$ad['model_id'];
            $this->model = $model->load($this->modelId)->getName();
            $this->price = (float)$ad['price'];
            $this->year = (int)$ad['year'];
            $this->typeId = (int)$ad['type_id'];
            $this->type = $type->load($this->typeId)->getName();
            $this->userId = (int)$ad['user_id'];
            $this->image = $ad['image'];
            $this->active = (int)$ad['active'];
            $this->slug = $ad['slug'];
            $this->createdAt = $ad['created_at'];
            $this->vin = $ad['vin'];
            $this->views = (int)$ad['views'];
        }

        return $this;
    }

    public function loadBySlug(string $slug): Ad
    {
        $man = new Manufacturer();
        $model = new Model();
        $type = new Type();
        $db = new DBHelper();

        $ad = $db->select()->from(self::TABLE)->where('slug', $slug)->getOne();

        if (!empty($ad)) {
            $this->id = (int)$ad['id'];
            $this->title = $ad['title'];
            $this->description = $ad['description'];
            $this->manufacturerId = (int)$ad['manufacturer_id'];
            $this->manufacturer = $man->load($this->manufacturerId)->getName();
            $this->modelId = (int)$ad['model_id'];
            $this->model = $model->load($this->modelId)->getName();
            $this->price = (float)$ad['price'];
            $this->year = (int)$ad['year'];
            $this->typeId = (int)$ad['type_id'];
            $this->type = $type->load($this->typeId)->getName();
            $this->userId = (int)$ad['user_id'];
            $this->image = $ad['image'];
            $this->active = (int)$ad['active'];
            $this->slug = $ad['slug'];
            $this->createdAt = $ad['created_at'];
            $this->vin = $ad['vin'];
            $this->views = (int)$ad['views'];
        }

        return $this;
    }

    public static function getAllAds(
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

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad((int)$element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getOrderedAds(
        string $orderField,
        string $orderMethod,
        bool   $activeOnly = true,
        ?int   $limit = null,
        ?int   $offset = null
    ): array
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        $db->orderby($orderField, $orderMethod);

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad((int)$element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getAdsLike(
        ?string $searchField,
                $searchValue,
        bool    $activeOnly = true,
        ?int    $limit = null,
        ?int    $offset = null
    ): array
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        $db->andWhere($searchField, '%' . $searchValue . '%', 'LIKE');

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad((int)$element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getOrderedAdsLike(
        string $orderField,
        string $orderMethod,
        string $searchField,
               $searchValue,
        bool   $activeOnly = true,
        ?int   $limit = null,
        ?int   $offset = null
    ): array
    {
        $db = new DBHelper();

        $db->select()->from(self::TABLE);

        if ($activeOnly) {
            $db->where('active', 1);
        }

        $db->andWhere($searchField, '%' . $searchValue . '%', 'LIKE')->orderby($orderField, $orderMethod);

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }
        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad((int)$element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getUserAds(
        int  $userId,
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

        $db->andWhere('user_id', $userId);

        if (isset($limit)) {
            $db->limit($limit);
        }

        if (isset($offset)) {
            $db->offset($offset);
        }

        $data = $db->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad((int)$element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getRelatedAds(int $id, int $limit): array
    {
        $db = new DBHelper();
        $ad = new Ad($id);
        $data = $db
            ->select()
            ->from(self::TABLE)
            ->where('active', 1)
            ->andWhere('id', $id, '<>')
            ->andWhere('model_id', $ad->getModelId())
            ->orWhere('active', 1)
            ->andWhere('id', $id, '<>')
            ->andWhere('manufacturer_id', $ad->getManufacturerId())
            ->limit($limit)
            ->get();

        $ads = [];

        foreach ($data as $element) {
            $ad = new Ad((int)$element['id']);
            $ads[] = $ad;
        }

        return $ads;
    }
}