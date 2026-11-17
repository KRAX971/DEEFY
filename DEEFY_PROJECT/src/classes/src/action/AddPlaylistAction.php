<?php
declare(strict_types=1);

namespace iutnc\deefy\action;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\audio\lists\Playlist;

class AddPlaylistAction extends Action {

    public function execute(): string {

        if ($this->http_method === 'GET') {
            return '<h2>Créer une playlist</h2>
                    <form method="post" action="?action=add-playlist">
                        <input type="text" name="nom" placeholder="Nom de la playlist" required>
                        <button type="submit">Créer</button>
                    </form>';
        }

        $nom = trim($_POST['nom'] ?? '');
        if ($nom === '') {
            return '<p>Le nom de la playlist est obligatoire.</p>
                    <p><a href="?action=add-playlist">Retour</a></p>';
        }

        $playlist = new Playlist($nom);
        $_SESSION['playlist'] = serialize($playlist);

        $renderer = new AudioListRenderer($playlist);
        return $renderer->render(Renderer::LONG).'<p><a href="?action=add-track">Ajouter une piste</a></p>';

    }
}
