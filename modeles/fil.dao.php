<?php
/**
 * @file fil.dao.php
 * 
 * @brief Classe FilDAO
 * 
 * @details Classe permettant de gérer les accès à la base de données pour les fils de discussion
 * 
 * @date 12/11/2024
 * 
 * @version 1.0
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class FilDAO {
    // Attributs
    /**
     * @var PDO|null $pdo Connexion à la base de données
     */
    private ?PDO $pdo;

    // Constructeur
    /**
     * @brief Constructeur de la classe FilDAO
     * 
     * @param PDO|null $pdo Connexion à la base de données
     */
    public function __construct(?PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Encapsulation
    // Getter
    /**
     * @brief Getter de la connexion à la base de données
     * @return PDO|null Connexion à la base de données
     */
    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    // Setter
    /**
     * @brief Setter de la connexion à la base de données
     * @param PDO $pdo Connexion à la base de données
     * @return self
     */
    public function setPdo(PDO $pdo): self {
        $this->pdo = $pdo;
        return $this;
    }

    // Méthodes
    // Méthodes d'hydratation
    /**
     * @brief Méthode d'hydratation d'un fil
     * 
     * @param array $row Ligne de la base de données
     * @return Fil Objet Fil hydraté
     */
    public function hydrate(array $row): Fil {
        // Création de l'objet Utilisateur
        $user = new Utilisateur();
        $user->setId($row['idUtilisateur']);
        $user->setPseudo($row['pseudo']);
        $user->setUrlImageProfil($row['urlImageProfil']);  // Correction de setUrlImageProfil

        // Création de l'objet Fil en incluant l'utilisateur
        $id = $row['idFil'];
        $titre = $row['titre'];
        $dateCreation = new DateTime($row['dateC']);
        $description = $row['description'];

        $fil = new Fil($id, $titre, $dateCreation, $description);
        $fil->setUtilisateur($user);  // Associer l'utilisateur au fil (en supposant que Fil a cette méthode)

        return $fil;
    }

    /**
     * @brief Méthode d'hydratation de tous les fils
     * 
     * @param array $rows Tableau de lignes de la base de données
     * @return array<Fil> Tableau d'objets Fil hydratés
     */
    function hydrateAll(array $rows): array {
        $fils = [];
        foreach ($rows as $row) {
            $fils[] = $this->hydrate($row);  // Ajout du fil au tableau
        }
        return $fils;
    }

    // Méthodes de recherche 
    /**
     * @brief Méthode pour lister tous les fils avec le premier utilisateur ayant posté
     * 
     * @return array<Fil> Tableau d'objets Fil
     */
    
    public function findAll(): array {
        $sql = "
            SELECT f.*, u.idUtilisateur, u.pseudo, u.urlImageProfil
            FROM " . DB_PREFIX . "fil AS f
            LEFT JOIN (
                SELECT m.idFil, MIN(m.dateC) AS firstDate
                FROM " . DB_PREFIX . "message AS m
                GROUP BY m.idFil
            ) AS first_message ON f.idFil = first_message.idFil
            LEFT JOIN " . DB_PREFIX . "message AS m ON f.idFil = m.idFil AND m.dateC = first_message.firstDate
            LEFT JOIN " . DB_PREFIX . "utilisateur AS u ON m.idUtilisateur = u.idUtilisateur;
        ";
        
        $stmt = $this->pdo->query($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $this->hydrateAll($stmt->fetchAll());
    }

    /**
     * @brief Méthode pour trouver un fil par son id
     * 
     * @details Méthode permettant de trouver un fil par son id - Sert à afficher un fil de discussion et ses messages sous-jacents
     *
     * @param integer $id Identifiant du fil
     * @return Fil|null
     */
    public function findById(int $id): ?Fil {
        $sql = "SELECT * FROM " . DB_PREFIX . "fil WHERE idFil = :id";  // Correction du nom de colonne
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $this->hydrate($stmt->fetch());
    }

    /**
     * @brief Méthode pour trouver les messages d'un fil par son id
     *
     * @param integer $idFil
     * @return array
     * @warning non testée
     */
    public function findMessagesByFilId(int $idFil): array {
        $sql = "
            SELECT m.*, u.idUtilisateur, u.pseudo, u.urlImageProfil
            FROM " . DB_PREFIX . "message AS m
            INNER JOIN " . DB_PREFIX . "utilisateur AS u ON m.idUtilisateur = u.idUtilisateur
            WHERE m.idFil = :idFil
            ORDER BY m.dateC ASC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':idFil', $idFil, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
    
}