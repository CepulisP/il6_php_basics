<?php

namespace Service\PriceChangeInformer;

use Helper\DBHelper;
use Model\Ad;
use Model\User;
use Model\Message;

class Cron
{
    public function exec(): void
    {
        $db = new DBHelper();
        $data = $db->select()->from('price_informer_queue')->limit(100)->get();
        foreach ($data as $element) {
            $user = new User($element['user_id']);
            $ad = new Ad($element['ad_id']);

            $messageText = 'Price of ad <a href=\"' . BASE_URL . 'catalog/show/' . $ad->getSlug() . '\">' . $ad->getTitle() . '</a> has changed';

            $message = new Message();
            $message->setMessage($messageText);
            $message->setSenderId(42);
            $message->setRecipientId($user->getId());
            $message->setSeen(0);
            $message->save();
            $db = new DBHelper();
            $db->delete()->from('price_informer_queue')->where('id', $element['id'])->exec();
        }
    }
}