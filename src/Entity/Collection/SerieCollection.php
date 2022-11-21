<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Serie;
use PDO;

class SerieCollection
{
    /** Méthode qui retourne la liste des séries.
     * @return Serie[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            ORDER BY name
            SQL
        );

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Serie::class);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
