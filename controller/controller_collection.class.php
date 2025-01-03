<?php

class ControllerCollection extends Controller {
    private TmdbAPICollection $tmdbApi;
    private CollectionDAO $collectionDAO;

    public function __construct(\Twig\Environment $twig, \Twig\Loader\FilesystemLoader $loader) {
        parent::__construct($twig, $loader);
        $this->collectionDAO = new CollectionDAO($this->getPdo());
        $this->tmdbApi = new TmdbAPICollection(TMDB_API_KEY, $this->collectionDAO);
    }

    /**
     * Affiche les informations d'une collection depuis TMDB sans l'importer
     */
    public function afficherCollection(): void {
        $tmdbId = isset($_GET['tmdb_id']) ? intval($_GET['tmdb_id']) : null;
        
        if ($tmdbId) {
            // Récupérer les données de la collection
            $collection = $this->tmdbApi->getCollectionById($tmdbId);
            
            if ($collection) {
                // Récupérer les genres de la collection
                $genres = $this->tmdbApi->getGenresFromCollection($tmdbId);

                // Récupérer tous les films de la collection
                $films = $this->tmdbApi->getMoviesFromCollection($tmdbId);

                //Récupérer les notes et le nombre de notes
                $commentaireDAO = new CommentaireDAO($this->getPdo());
                $notes = $commentaireDAO->getMoyenneEtTotalNotesCollection($tmdbId);
   
                //Récupérer les commentaires
                $commentaires = $commentaireDAO->getCommentairesCollection($tmdbId);
                
                // Afficher le template avec les données
                echo $this->getTwig()->render('pageDuneCollection.html.twig', [
                    'collection' => $collection,
                    'themes' => $genres,
                    'films' => $films,
                    'moyenne' => $notes['moyenne'],
                    'total' => $notes['total'],
                    'commentaires' => $commentaires,
                ]);
                return;
            }
        }

        // Si pas d'ID ou collection non trouvée, rediriger vers la page d'accueil
        echo $this->getTwig()->render('index.html.twig');

    }
} 