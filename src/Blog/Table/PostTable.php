<?php

namespace Jojotique\Blog\Table;

use Jojotique\Blog\Entity\Post;
use Jojotique\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use PDO;
use stdClass;

class PostTable
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * PostTable constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param int $perPage
     * @param int $currentPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            'SELECT * FROM posts ORDER BY createdAt DESC',
            'SELECT COUNT(id) FROM posts',
            Post::class
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * @param int $id
     * @return Post
     */
    public function find(int $id): Post
    {
        $result = $this->pdo->prepare('SELECT * FROM posts WHERE id=?');
        $result->execute([$id]);
        $result->setFetchMode(PDO::FETCH_CLASS, Post::class);
        return $result->fetch();
    }
}
