<?php

declare(strict_types=1);

namespace Model;

use Core\DB;
use Core\ModelAbstract;
use Aura\SqlQuery\QueryFactory;

class News extends ModelAbstract
{
    public const TABLE = 'news';

    private string $title;

    private string $content;

    private int $authorId;

    private int $active;

    private int $views;

    private string $slug;

    private string $image;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
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
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews(int $views): void
    {
        $this->views = $views;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
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
            'title' => $this->title,
            'content' => $this->content,
            'author_id' => $this->authorId,
            'active' => $this->active,
            'views' => $this->views,
            'slug' => $this->slug,
            'image' => $this->image
        ];

    }

    public function loadBySlug(string $slug): ?News
    {

        $sql = $this->select();
        $sql->cols(['*'])->from('news')->where('slug = :slug')->bindValue('slug', $slug);

        if ($rez = $this->db->get($sql)) {

            $this->id = (int)$rez['id'];
            $this->title = $rez['title'];
            $this->content = $rez['content'];
            $this->authorId = (int)$rez['author_id'];
            $this->createdAt = $rez['created_at'];
            $this->active = (int)$rez['active'];
            $this->views = (int)$rez['views'];
            $this->slug = $rez['slug'];
            $this->image = $rez['image'];

            return $this;

        }

        return null;

    }

    public function load(int $id): ?News
    {

        $sql = $this->select();
        $sql->cols(['*'])->from('news')->where('id = :id')->bindValue('id', $id);

        if ($rez = $this->db->get($sql)) {

            $this->id = (int) $rez['id'];
            $this->title = $rez['title'];
            $this->content = $rez['content'];
            $this->authorId = (int) $rez['author_id'];
            $this->createdAt = $rez['created_at'];
            $this->active = (int) $rez['active'];
            $this->views = (int) $rez['views'];
            $this->slug = $rez['slug'];
            $this->image = $rez['image'];

            return $this;

        }

        return null;

    }

}