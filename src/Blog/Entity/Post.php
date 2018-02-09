<?php

namespace Jojotique\Blog\Entity;

use DateTime;

class Post
{
    private $id;
    private $name;
    private $slug;
    private $content;
    private $createdAt;
    private $updatedAt;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        if ($this->createdAt) {
            $this->createdAt = new DateTime($this->createdAt);
        }

        if ($this->updatedAt) {
            $this->updatedAt = new DateTime($this->updatedAt);
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
