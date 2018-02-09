<?php

namespace Jojotique\Database;

use Pagerfanta\Adapter\AdapterInterface;
use PDO;
use Traversable;

class PaginatedQuery implements AdapterInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $statement;

    /**
     * @var string
     */
    private $count;

    /**
     * @var string
     */
    private $entityUsed;

    /**
     * PaginatedQuery constructor.
     * @param PDO $pdo
     * @param string $statement Récupère X résultat
     * @param string $count Compte le nombre de résultat total
     * @param null|string $entityUsed
     */
    public function __construct(PDO $pdo, string $statement, string $count, ?string $entityUsed = null)
    {
        $this->pdo = $pdo;
        $this->statement = $statement;
        $this->count = $count;
        $this->entityUsed = $entityUsed;
    }

    /**
     * Retourne le nombre de résultats
     *
     * @return int
     */
    public function getNbResults(): int
    {
        return $this->pdo->query($this->count)->fetchColumn();
    }

    /**
     * Returns an slice of the results.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return array Tableau des entités.
     */
    public function getSlice($offset, $length): array
    {
        $results = $this->pdo->prepare($this->statement . ' LIMIT :offset, :length');
        $results->bindParam('offset', $offset, PDO::PARAM_INT);
        $results->bindParam('length', $length, PDO::PARAM_INT);

        if ($this->entityUsed !== null) {
            $results->setFetchMode(PDO::FETCH_CLASS, $this->entityUsed);
        }

        $results->execute();

        return $results->fetchAll();
    }
}
