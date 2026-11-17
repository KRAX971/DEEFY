<?php
declare(strict_types=1);

namespace iutnc\deefy\action;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\render\AudioListRenderer;

class DisplayPlaylistAction extends Action {

    public function execute(): string {

        if (!isset($_SESSION['playlist'])) {
    return '<p>Aucune playlist courante.</p>
            <p><a href="?action=add-playlist">Créer une playlist</a></p>';
}

$playlist = unserialize($_SESSION['playlist']);
return (new AudioListRenderer($playlist))->render(Renderer::LONG)
     . '<p><a href="?action=add-track">Ajouter une piste</a></p>';

     
        $html = '<h2>' . htmlspecialchars($playlist->nom) . '</h2>';
        $html .= '<p>' . $playlist->nbPistes . ' piste(s) - durée totale : '
               . $playlist->dureeTotale . ' s</p><ul>';

        foreach ($playlist->pistes as $piste) {
            $html .= '<li>' . htmlspecialchars($piste->titre);
            if ($piste->auteur !== null) {
                $html .= ' (' . htmlspecialchars($piste->auteur) . ')';
            }
            $html .= '</li>';
        }
        return $html . '</ul>';
    }
}
