<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Saison;
use PDO;

class SaisonCollection
{
    /** Méthode qui retourne la liste des saisons selon la série.
     * @param int $SerieId id de la série en question
     * @return Saison[] liste des saisons de la série
     */
    public static function findByTvShowId(int $SerieId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT id, tvShowId, name, seasonNumber, posterId
                FROM season
                WHERE tvShowid = :idS
            SQL
        );

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Saison::class);
        $stmt->execute([':idS' => $SerieId]);

        return $stmt->fetchAll();
    }
}
