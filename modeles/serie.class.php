<?php

/**
 * @brief Classe représentant une série TV
 * 
 * Cette classe contient toutes les informations relatives à une série TV
 * 
 * @author François Barlic <<francois.barlic57@gmail.com>>
 * @version 1.0
 */
class Serie
{
    private int $id;
    private string $titre;
    private string $description;
    private DateTime $datePremiereAir;
    private ?string $lienAffiche;
    private int $nombreSaisons;
    private int $nombreEpisodes;

    /**
     * @brief Constructeur de la classe Serie
     * 
     * @param int $id Identifiant de la série
     * @param string $titre Titre de la série
     * @param string $description Description de la série
     * @param DateTime $datePremiereAir Date de première diffusion
     * @param string|null $lienAffiche Lien vers l'affiche de la série
     * @param int $nombreSaisons Nombre de saisons
     * @param int $nombreEpisodes Nombre total d'épisodes
     */
    public function __construct(
        int $id,
        string $titre,
        string $description,
        DateTime $datePremiereAir,
        ?string $lienAffiche,
        int $nombreSaisons,
        int $nombreEpisodes
    ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->datePremiereAir = $datePremiereAir;
        $this->lienAffiche = $lienAffiche;
        $this->nombreSaisons = $nombreSaisons;
        $this->nombreEpisodes = $nombreEpisodes;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getDatePremiereAir(): DateTime
    {
        return $this->datePremiereAir;
    }

    /**
     * @param DateTime $datePremiereAir
     */
    public function setDatePremiereAir(DateTime $datePremiereAir): void
    {
        $this->datePremiereAir = $datePremiereAir;
    }

    /**
     * @return string|null
     */
    public function getLienAffiche(): ?string
    {
        return $this->lienAffiche;
    }

    /**
     * @param string|null $lienAffiche
     */
    public function setLienAffiche(?string $lienAffiche): void
    {
        $this->lienAffiche = $lienAffiche;
    }

    /**
     * @return int
     */
    public function getNombreSaisons(): int
    {
        return $this->nombreSaisons;
    }

    /**
     * @param int $nombreSaisons
     */
    public function setNombreSaisons(int $nombreSaisons): void
    {
        $this->nombreSaisons = $nombreSaisons;
    }

    /**
     * @return int
     */
    public function getNombreEpisodes(): int
    {
        return $this->nombreEpisodes;
    }

    /**
     * @param int $nombreEpisodes
     */
    public function setNombreEpisodes(int $nombreEpisodes): void
    {
        $this->nombreEpisodes = $nombreEpisodes;
    }
}
