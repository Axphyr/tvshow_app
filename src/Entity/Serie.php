<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\SaisonCollection;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Serie
{
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    private ?int $posterId;


    /**
     * constructeur privé
     */
    private function __construct()
    {
    }

    /**
     * @return int|null Identifiant de la série
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id Identifiant de la série
     */
    private function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string Nom de la série
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name Nom de la série
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string Nom original de la série
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName Nom original de la série
     */
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string page d'accueil
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * @param string $homepage page d'accueil
     */
    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }

    /**
     * @return string résumé de la série
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview résumé de la série
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return int|null id du poster de la série
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @param int|null $posterId id du poster de la série
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * @param int $id Identifiant de la série
     * @return Serie Serie
     */
    public static function findById(int $id): Serie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT id, name, originalName, homepage, overview, posterId
                FROM tvshow
                WHERE id = :idS
            SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Serie::class);
        $stmt->execute([':idS' => $id]);

        $serie = $stmt->fetch();

        if ($serie === false) {
            throw new EntityNotFoundException("Data cannot be found.");
        }
        return $serie;
    }

    /**
     * @return $this Instance de la série venant d'etre supprimée
     */
    public function delete(): Serie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                DELETE
                FROM tvshow
                WHERE id = :idSerie
                SQL
        );
        $stmt->execute([":idSerie" => $this->getId()]);
        $this->setId(null);

        return $this;
    }

    /**
     * @return $this Instance de la série venant d'etre modifié
     */
    protected function update(): Serie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                UPDATE tvshow
                    SET name = :nameSerie, 
                        originalName = :originalName,
                        homepage = :homepage,
                        overview = :overview,
                        posterId = :posterId
                    WHERE id = :idSerie
                SQL
        );
        $stmt->execute([":idSerie" => $this->getId(),
                        ":nameSerie" => $this->getName() ,
                        ":originalName" => $this->getOriginalName(),
                        ":homepage" => $this->getHomepage(),
                        ":overview" => $this->getOverview(),
                        ":posterId" => $this->getPosterId()]);

        return $this;
    }

    /**
     * @return Serie Instance de l'artiste venant d'etre Ajoutée
     */
    protected function insert(): Serie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                INSERT INTO tvshow(name, originalName, homepage, overview, posterId)
                    VALUES (:nomSerie, :originalName, :homepage, :overview, :posterId)
                SQL
        );
        $stmt->execute([":nomSerie" => $this->getName() ,
                        ":originalName" => $this->getOriginalName(),
                        ":homepage" => $this->getHomepage(),
                        ":overview" => $this->getOverview(),
                        ":posterId" => $this->getPosterId()]);
        $this->setId((int)MyPDO::getInstance()->lastInsertId());
        return $this;
    }

    /**
     * @return $this Artiste
     */
    public function save(): Serie
    {
        if ($this->getId() == null) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }

    /**
     * @param string $name nom de la serie
     * @param string $originalName nom original de la serie
     * @param string $homepage page d'accueil
     * @param string $overview résumé
     * @param int|null $id id de la série
     * @param int|null $posterId id de l'affiche de la série
     * @return Serie
     */
    public static function create(string $name, string $originalName, string $homepage, string $overview, ?int $id = null, ?int $posterId = null): Serie
    {
        $serie = new Serie();
        $serie->setId($id);
        $serie->setName($name);
        $serie->setOriginalName($originalName);
        $serie->setHomepage($homepage);
        $serie->setOverview($overview);
        $serie-> setPosterId($posterId);
        return $serie;
    }

    /**
     * @return array Liste des saisons de la série
     */
    public function getAlbums(): array
    {
        return SaisonCollection::findByTvShowId($this->id);
    }
}
