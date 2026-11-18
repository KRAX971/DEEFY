<?php

namespace iutnc\deefy\audio\tracks;

/*
 * Classe PodcastTrack
 * 
 * Hérite de AudioTrack pour représenter un épisode de podcast.
 * Elle ajoute les propriétés spécifiques aux podcasts, à savoir l'auteur/présentateur
 * et la date de publication de l'épisode.
 */

class PodcastTrack extends AudioTrack {
    protected ?string $auteur = null;
    protected ?string $date = null;

    public function __construct(string $titre, string $chemin) {
        parent::__construct($titre, $chemin);
    }

    public function setAuteur(string $auteur): void {
        $this->auteur = $auteur;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }
}
?>