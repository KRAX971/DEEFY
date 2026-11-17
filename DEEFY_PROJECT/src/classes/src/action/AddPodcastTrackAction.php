<?php
declare(strict_types=1);

namespace iutnc\deefy\action;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\repository\DeefyRepository;
class AddPodcastTrackAction extends Action {

    public function execute(): string {

        if (!isset($_SESSION['playlist'])) {
            return '<p>Crée d\'abord une playlist.</p>
                    <p><a href="?action=add-playlist">Créer une playlist</a></p>';
        }

        if ($this->http_method === 'GET') {
            return '<h2>Ajouter un podcast</h2>
                    <form method="post" action="?action=add-track">
                        <p><input type="text" name="titre" placeholder="Titre" required></p>
                        <p><input type="text" name="auteur" placeholder="Auteur"></p>
                        <p><input type="number" name="duree" placeholder="Durée (secondes)" min="0"></p>
                        <p><input type="text" name="fichier" placeholder="Nom du fichier (ex: ep1.mp3)"></p>
                        <button type="submit">Ajouter</button>
                    </form>';
        }

        $titre   = trim($_POST['titre'] ?? '');
        $auteur  = trim($_POST['auteur'] ?? '');
        $duree   = (int) ($_POST['duree'] ?? 0);
        $fichier = trim($_POST['fichier'] ?? '');

        if ($titre === '') {
            return '<p>Le titre est obligatoire.</p>
                    <p><a href="?action=add-track">Retour</a></p>';
        }
        if ($fichier === '') {
            $fichier = 'fichier.mp3';
        }

        $playlist = unserialize($_SESSION['playlist']);

        $piste = new PodcastTrack($titre, $fichier);
        if ($auteur !== '') {
            $piste->setAuteur($auteur);
        }
        $piste->setDuree(max(0, $duree));
        DeefyRepository::getInstance()->addTrackPlaylist($playlist->id, $piste);
        $playlist->ajouterPiste($piste);
        $_SESSION['playlist'] = serialize($playlist);

        $renderer = new AudioListRenderer($playlist);
        return $renderer->render(Renderer::LONG). '<p><a href="?action=add-track">Ajouter encore une piste</a></p>';
    }
}
