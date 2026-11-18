<?php
namespace iutnc\deefy\action;
use iutnc\deefy\repository\DeefyRepository;

class MyPlaylistsAction extends Action {

    public function execute(): string {
        $playlists = DeefyRepository::getInstance()->findAllPlaylists();
        if (count($playlists) === 0) {
            return '<h2>Mes playlists</h2><p>Aucune playlist.</p>';
        }
        $html = '<h2>Mes playlists</h2><ul>';
        foreach ($playlists as $pl) {
            $html .= '<li><a href="?action=playlist&amp;id=' . (int) $pl['id'] . '">'
                . htmlspecialchars($pl['nom'], ENT_QUOTES, 'UTF-8')
                . '</a></li>';
        }
        return $html . '</ul>';
    }
}