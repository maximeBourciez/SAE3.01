<?php

class QuizzDAO{

    // Attributs
    private $pdo;

    // Constructeur
    function __construct(?PDO $pdo = null){
        $this->pdo = $pdo;
    }

    // Méthodes

    function create(Quizz $quizz): bool{
        $req = $this->pdo->prepare("INSERT INTO Quizz (titre, description, difficulte, date) VALUES (:titre, :description, :difficulte, :date)");
        $req->bindParam(":titre", $quizz->getTitre());
        $req->bindParam(":description", $quizz->getDescription());
        $req->bindParam(":difficulte", $quizz->getDifficulte());
        $req->bindParam(":date", $quizz->getDate());
        return $req->execute();
    }

    function update(Quizz $quizz): bool{
        $req = $this->pdo->prepare("UPDATE Quizz SET titre = :titre, description = :description, difficulte = :difficulte, date = :date WHERE id = :id");
        $req->bindParam(":id", $quizz->getId());
        $req->bindParam(":titre", $quizz->getTitre());
        $req->bindParam(":description", $quizz->getDescription());
        $req->bindParam(":difficulte", $quizz->getDifficulte());
        $req->bindParam(":date", $quizz->getDate());
        return $req->execute();
    }

    function delete(int $id): bool{
        $req = $this->pdo->prepare("DELETE FROM Quizz WHERE id = :id");
        $req->bindParam(":id", $id);
        return $req->execute();
    }

    function hydrate(array $row): Quizz{
        // Récupération des valeurs
        $id = $row['id'];
        $titre = $row['titre'];
        $description = $row['description'];
        $difficulte = $row['difficulte'];
        $date = $row['date'];

        // Retourner le Quizz
        return new Quizz($id, $titre, $description, $difficulte, $date);
    }

    function hydrateAll(array $rows): array{
        $quizzs = [];
        foreach($rows as $row){
            $quizz = $this->hydrate($row);
            array_push($quizzs, $quizz);  // Ajout du Quizz au tableau 
        }
        return $quizzs;
    }

    function find(int $id): ?Quizz{
        $sql = "SELECT * FROM Quizz WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row == null){
            return null;
        }
        return $this->hydrate($row);
    }
}