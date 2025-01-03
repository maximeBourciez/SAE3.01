<?php

class ControllerContenu extends Controller {
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FilesystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * Affiche les informations d'un film depuis TMDB sans l'importer
     */
    public function afficherContenu(): void {
        $tmdbId = isset($_GET['tmdb_id']) ? intval($_GET['tmdb_id']) : null;
        if ($tmdbId) {
            // Initialiser l'API TMDB
            $tmdbApi = new TmdbAPIContenu(TMDB_API_KEY);
            
            // Récupérer les données du film
            $movieData = $tmdbApi->getMovieById($tmdbId);
            if ($movieData === null) {
                // Si getMovieById retourne null (cas d'un film pour adultes)
                echo $this->getTwig()->render('index.html.twig');
                return;
            }
            if ($movieData) {
                // Convertir en objet Contenu sans sauvegarder
                $contenu = $tmdbApi->convertToContenu($movieData);
                
                // Récupérer les personnalités
                $personnalites = $tmdbApi->getPersonnalitesContenu($movieData);
                
                // Récupérer les thèmes
                $themes = $tmdbApi->getGenresContenu($movieData);

                //Récupérer les notes et le nombre de notes
                $commentaireDAO = new CommentaireDAO($this->getPdo());
                $notes = $commentaireDAO->getMoyenneEtTotalNotesContenu($tmdbId);

                //Récupérer les commentaires
                $commentaires = $commentaireDAO->getCommentairesContenu($tmdbId);
                
                // Récupérer les thèmes depuis la BD
                $themeDAO = new ThemeDAO($this->getPdo());
                $themesFromDB = [];
                
                // Pour chaque thème de TMDB
                foreach ($themes as $theme) {
                    $themeFromDB = $themeDAO->createIfNotExists($theme);
                    if ($themeFromDB) {
                        $themesFromDB[] = $themeFromDB;
                    }
                }
                
                // Afficher le template avec les données
                echo $this->getTwig()->render('pageDunContenu.html.twig', [
                    'contenu' => $contenu,
                    'personnalite' => $personnalites,
                    'themes' => $themesFromDB,
                    'moyenne' => $notes['moyenne'],
                    'total' => $notes['total'],
                    'commentaires' => $commentaires
                ]);
                return;
            }
        }


        // Si pas d'ID ou contenu non trouvée, rediriger vers la page d'accueil
        echo $this->getTwig()->render('index.html.twig');
    }
} 