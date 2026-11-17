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

public function supprimerPiste(int $indice): void {
    if (isset($this->pistes[$indice])) {
        $this->dureeTotale -= $this->pistes[$indice]->duree;
        unset($this->pistes[$indice]);
        $this->pistes = array_values($this->pistes);
        $this->nbPistes = count($this->pistes);
    }
}

    

        public function ajouterPistes(array $nouvellesPistes): void {
        foreach ($nouvellesPistes as $piste) {
            $this->ajouterPiste($piste);
        }
    }
}
?>