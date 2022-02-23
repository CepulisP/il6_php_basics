<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Comment extends AbstractModel
{
    private $comment;

    private $adId;

    private $userId;

    private $createdAt;

    protected const TABLE = 'comments';

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($id)
    {
        $this->userId = $id;
    }

    public function getAdId()
    {
        return $this->adId;
    }

    public function setAdId($id)
    {
        $this->adId = $id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUser()
    {
        $array = User::getUser($this->userId);
        return $array[0];
    }

    protected function assignData()
    {
        $this->data = [
            'comment' => $this->comment,
            'ad_id' => $this->adId,
            'user_id' => $this->userId
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $comment = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($comment)) {
            $this->comment = $comment['comment'];
            $this->adId = $comment['ad_id'];
            $this->userId = $comment['user_id'];
            $this->createdAt = $comment['created_at'];
        }
        return $this;
    }

    public static function getAllComments()
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $comments = [];

        foreach ($data as $element) {
            $comment = new Comment();
            $comment->load($element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }

    public static function getAdComments($adId)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('ad_id', $adId)->orderby('created_at', 'DESC')->get();
        $comments = [];

        foreach ($data as $element) {
            $comment = new Comment();
            $comment->load($element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }

    public static function getUserComments($userId)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('user_id', $userId)->get();
        $comments = [];

        foreach ($data as $element) {
            $comment = new Comment();
            $comment->load($element['id']);
            $comments[] = $comment;
        }

        return $comments;
    }
}