<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;
    private string $jpeg;

    /**
     * @return int id de la pochette
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string visuel de la pochette (de type « mediumblob »)
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @param int $id Identifiant du poster
     * @return Poster Poster
     */
    public static function findById(int $id = null): Poster
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT id, jpeg
                FROM poster
                WHERE id = :idPoster
                SQL
        );

        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Poster::class);
        $stmt->execute([":idPoster" => $id]);
        $cov = $stmt->fetch();

        if ($cov === false) {
            throw new EntityNotFoundException("Aucun Poster correspond à l'Id");
        }

        return $cov;
    }
}
