<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class SavedAd extends AbstractModel implements ModelInterface
{
    protected const TABLE = 'saved_ads';

    private int $adId;

    private int $userId;


    public function getAdId(): int
    {
        return $this->adId;
    }

    public function setAdId(int $adId): void
    {
        $this->adId = $adId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function assignData(): void
    {
        $this->data = [
            'ad_id' => $this->adId,
            'user_id' => $this->userId
        ];
    }

    public function load(int $id): ?SavedAd
    {
        $db = new DBHelper();
        $savedAd = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($savedAd)) {
            $this->id = (int)$savedAd['id'];
            $this->adId = (int)$savedAd['ad_id'];
            $this->userId = (int)$savedAd['user_id'];
            return $this;
        }
        return null;
    }

    public function loadByUserAndAd(int $adId, int $userId): ?SavedAd
    {
        $db = new DBHelper();
        $savedAd = $db->select()->from(self::TABLE)->where('user_id', $userId)->andWhere('ad_id', $adId)->getOne();

        if (!empty($savedAd)) {
            $this->id = (int)$savedAd['id'];
            $this->adId = (int)$savedAd['ad_id'];
            $this->userId = (int)$savedAd['user_id'];
            return $this;
        }
        return null;
    }

    public static function getSavedUserAds(int $userId): array
    {
        $db = new DBHelper();
        return $db->select()->from(self::TABLE)->where('user_id', $userId)->get();
    }

    public static function getSavedAdUsers(int $adId): array
    {
        $db = new DBHelper();
        return $db->select()->from(self::TABLE)->where('ad_id', $adId)->get();
    }

    public static function hasUserSaved(int $adId, int $userId): bool
    {
        $db = new DBHelper();
        $rez = $db->select()->from(self::TABLE)->where('user_id', $userId)->andWhere('ad_id', $adId)->get();
        return !empty($rez);
    }
}