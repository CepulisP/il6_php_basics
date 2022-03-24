<?php

namespace Service\PriceChangeInformer;

use Model\SavedAd;
use Helper\DBHelper;

class Messenger
{
    public function setMessages(int $adId): void
    {
        $userIds = SavedAd::getSavedAdUserIds($adId);
        foreach ($userIds as $userId){
            $db = new DBHelper();
            $data = [
                'user_id' => $userId,
                'ad_id' => $adId
            ];
            $db->insert('price_informer_queue', $data)->exec();
        }
    }
}