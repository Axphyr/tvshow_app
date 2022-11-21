<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    /** Méthode qui retourne la liste des épisodes selon la série et la saison.
     * @param int $SerieId identifiant de la série
     * @param int $SeasonId identifiant de la saison
     * @return array liste des épisodes de la saison
     */
    public static function findByTvShowId(int $SerieId, int $SeasonId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT e.id, e.seasonId, e.name, e.overview, e.episodeNumber
                FROM season s, episode e
                WHERE s.id = e.seasonId
                    AND s.tvShowId = :idSerie
                    AND e.seasonId = :idSeason
            SQL
        );

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Episode::class);
        $stmt->execute([':idSerie' => $SerieId, ':idSeason' => $SeasonId]);

        return $stmt->fetchAll();
    }
}
