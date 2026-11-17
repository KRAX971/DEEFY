<?php
declare(strict_types=1);

namespace iutnc\deefy\action;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class DisplayPlaylistAction extends Action{

    public function execute(): string
    {

        if (isset($_GET['id'])) {
            $playlist = DeefyRepository::getInstance()->findPlaylistById((int)$_GET['id']);
            if ($playlist === null) {
                return '<p>Playlists introuvables</p>
                        <p><a href="?action=playlists">Retour aux playlists</a></p>';
            }
            $_SESSION['playlist'] = serialize($playlist);
        } else {
            if (isset($_SESSION['playlist'])) {
                $playlist = unserialize($_SESSION['playlist']);
            } else {
                return '<p>Playlists introuvables</p>
                    <p><a href="?action=playlists">Mes playlists</a> |
                <a href="?action=add-playlist">Créer une playlist</a></p>';
            }
        }
        return (new AudioListRenderer($playlist))->render(Renderer::LONG)
            . '<p><a href="?action=add-track">Ajouter une piste</a></p>';
    }
}
