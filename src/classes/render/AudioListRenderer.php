<?php
declare(strict_types=1);

namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;

class AudioListRenderer implements Renderer {
    private AudioList $list;

    public function __construct(AudioList $list) {
        $this->list = $list;
    }

    public function render(int $selector): string {
        // On nettoie le nom avant de l'afficher (protection XSS)
        $nom = filter_var($this->list->nom, FILTER_SANITIZE_SPECIAL_CHARS);

        $html = "<h2>$nom</h2><ul>";

        foreach ($this->list->pistes as $piste) {
            $titre = filter_var($piste->titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = $piste->duree ?? 0;
            $html .= "<li>$titre ($duree s)</li>";
        }

        $html .= '</ul>';
        $html .= '<p>Nombre de pistes : ' . $this->list->nbPistes . '</p>';
        $html .= '<p>Durée totale : ' . $this->list->dureeTotale . ' s</p>';

        return $html;
    }
}