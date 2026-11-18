<?php
namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack;

class Playlist extends AudioList{

public function ajouterPiste(AudioTrack $piste): void {
    if (!in_array($piste, $this->pistes, true)) {
        $this->pistes[] = $piste;
        $this->nbPistes = count($this->pistes);
        $this->dureeTotale += $piste->duree;
    }
}

        public function ajouterPistes(array $nouvellesPistes): void {
        foreach ($nouvellesPistes as $piste) {
            $this->ajouterPiste($piste);
        }
    }
}
?>