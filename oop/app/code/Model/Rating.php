<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\Logger;

class Rating extends AbstractModel implements ModelInterface
{
    private int $rating;

    private int $adId;

    private int $userId;

    protected const TABLE = 'ratings';

    public function __construct(?int $id = null)
    {
        if ($id !== null) {
            $this->load($id);
        }
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

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
            'rating' => $this->rating,
            'ad_id' => $this->adId,
            'user_id' => $this->userId
        ];
    }

    public function load(int $id): Rating
    {
        $db = new DBHelper();
        $rating = $db->select()->from(self::TABLE)->where('id', $id)->getOne();

        if (!empty($rating)) {
            $this->id = (int)$rating['id'];
            $this->rating = (int)$rating['rating'];
            $this->adId = (int)$rating['ad_id'];
            $this->userId = (int)$rating['user_id'];
        }

        return $this;
    }

    public static function getAdRating(int $adId): float
    {
        $db = new DBHelper();
        $ratings = $db->select()->from(self::TABLE)->where('ad_id', $adId)->get();
        $result = 0;
        $i = 0;

        foreach ($ratings as $rating){
            $result += $rating['rating'];
            $i++;
        }

        return $i > 0 ? $result / $i : 0;
    }

    public static function hasUserRated(int $userId, int $adId): bool
    {
        $db = new DBHelper();
        $rez = $db->select()->from(self::TABLE)->where('ad_id', $adId)->andWhere('user_id', $userId)->getOne();
        return !empty($rez);
    }

    public static function getUserRating(int $userId, int $adId): int
    {
        $db = new DBHelper();
        $rez = $db->select()->from(self::TABLE)->where('ad_id', $adId)->andWhere('user_id', $userId)->getOne();
        return $rez['rating'];
    }
}