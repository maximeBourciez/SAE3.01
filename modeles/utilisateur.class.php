<?php

enum Role {
    case Utilisateur;
    case Moderateur;

    // Méthode pour récupérer l'instance de l'énum à partir d'une chaîne
    public static function fromString(string $value): ?Role {
        foreach (self::cases() as $role) {
            if ($role->name === $value) {
                return $role;
            }
        }
        return null; // Retourne null si aucune correspondance
    }

    // Méthode pour convertir une instance de Role en chaîne
    public function toString(): string {
        return $this->name;
    }
}

class Utilisateur{
    // Attributs
    private ?string $id;
    private ?string $pseudo;
    private ?string $nom;
    private ?string $mail;
    private ?string $mdp;
    private ?Role $role;
    private ?string $urlImageProfil;
    private ?string $urlImageBanniere;
    
    // Constructeur
    function __construct(?string $id = null, ?string $pseudo = null, ?string $nom = null, ?string $mail = null, ?string $mdp = null, ?Role $role = null, ?string $urlImageProfil = null, ?string $urlImageBanniere = null){
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->mdp = $mdp;
        $this->role = $role;
        $this->urlImageProfil = $urlImageProfil;
        $this->urlImageBanniere = $urlImageBanniere;
    }

    // Encapsulation
    
    
    // Getters

    /**
     * Get the value of id
     * @return string
     */ 
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Get the value of pseudo
     * @return string
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * Get the value of nom
     * @return string
     */
    public function getNom(): ?string {
        return $this->nom;
    }

    /**
     * Get the value of mail
     * @return string
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Get the value of mdp
     * @return string
     */
    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    /**
     * Get the value of role
     * @return Role
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * Get the value of urlImagePofil
     * @return string
     */
    public function getUrlImageProfil(): ?string
    {
        return $this->urlImageProfil;
    }

    /**
     * Get the value of urlImageBanniere
     * @return string
     */
    public function getUrlImageBanniere(): ?string
    {
        return $this->urlImageBanniere;
    }

    // Setters

    /**
     * Set the value of id
     * @return void
     */ 
    public function setId(?string $id = null): void
    {
        $this->id = $id;
    }

    /**
     * Set the value of pseudo
     * @return void
     */
    public function setPseudo(?string $pseudo = null): void
    {
        $this->pseudo = $pseudo;
    }
    /**
     * Set the value of nom
     * @return void
     */
    public function setNom(?string $nom = null): void
    {
        $this->nom = $nom;
    }

    /**
     * Set the value of mail
     * @return void
     */
    public function setMail(?string $mail = null): void
    {
        $this->mail = $mail;
    }

    /**
     * Set the value of mdp
     * @return void
     */
    public function setMdp(?string $mdp = null): void
    {
        $this->mdp = $mdp;
    }

    /**
     * Set the value of role
     * @return void
     */
    public function setRole(?Role $role = null): void
    {
        $this->role = $role;
    }

    /**
     * Set the value of urlImagePofil
     * @return void
     */
    public function setUrlImageProfil(?string $urlImagePofil = null): void
    {
        $this->urlImageProfil = $urlImagePofil;
    }

    /**
     * Set the value of urlImageBanniere
     * @return void
     */
    public function setUrlImageBanniere(?string $urlImageBanniere = null): void
    {
        $this->urlImageBanniere = $urlImageBanniere;
    }

    // Méthodes 

}