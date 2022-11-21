<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Serie;
use PDO;

class SerieGenreCollection
{
    /** Méthode qui retourne la liste des séries selon le genre
     * @return Serie[]
     */
    public static function findAll(int $genreId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT tv.id, tv.name, tv.originalName, tv.homepage, tv.overview, tv.posterId
            FROM tvshow tv, tvshow_genre tvg
            WHERE tv.id = tvg.tvShowId
                AND tvg.genreId = :genreId
            ORDER BY name
            SQL
        );

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Serie::class);
        $stmt->execute([':genreId' => $genreId]);

        return $stmt->fetchAll();
    }
}
