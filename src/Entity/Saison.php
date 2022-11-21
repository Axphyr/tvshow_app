<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Saison
{
    private int $id;
    private int $tvShowId;
    private string $name;
    private int $seasonNumber;
    private int $posterId;

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
     * @return int
     */
    public function getTvShow(): int
    {
        return $this->tvShowId;
    }

    /**
     * @return int
     */
    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    public static function findById(int $idSerie, int $idSaison): Saison
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT id, tvShowId, name, seasonNumber, posterId
                FROM season
                WHERE tvShowId = :idSerie
                    AND id = :idSaison
            SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Saison::class);
        $stmt->execute([':idSerie' => $idSerie, ':idSaison' => $idSaison]);

        $saison= $stmt->fetch();

        if ($saison === false) {
            throw new EntityNotFoundException("Data cannot be found.");
        }
        return $saison;
    }
}
