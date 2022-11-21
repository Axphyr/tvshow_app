<?php

declare(strict_types=1);

namespace Entity;

class Episode
{
    private int $id;
    private int $seasonId;
    private string $name;
    private string $overview;
    private int $episodeNumber;

    /**
     * @return int Id de l'Episode
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int Id de la saison de l'épisode
     */
    public function getSeasonId(): int
    {
        return $this->seasonId;
    }

    /**
     * @return string Nom de l'épisode
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string résumé de l'épisode
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @return int Numéro d'épisode
     */
    public function getEpisodeNumber(): int
    {
        return $this->episodeNumber;
    }
}
