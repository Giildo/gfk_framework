<?php

namespace Jojotique\Blog\Table;

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
     * @param int|null $limit
     * @return stdClass[]
     */
    public function findAll(?int $limit = null): array
    {
        if ($limit === null) {
            $result = $this->pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
        } else {
            $result = $this->pdo->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT ' . $limit);
        }

        return $result->fetchAll();
    }

    /**
     * @param int $id
     * @return stdClass
     */
    public function find(int $id): stdClass
    {
        $result = $this->pdo->prepare('SELECT * FROM posts WHERE id=?');
        $result->execute([$id]);
        return $result->fetch();
    }
}
