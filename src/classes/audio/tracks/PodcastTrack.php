<?php
namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack {
    protected ?string $auteur = null;
    protected ?string $date = null;
    //constructeur de podcast
    public function __construct(string $titre, string $chemin) {
        parent::__construct($titre, $chemin);
    }
    //insert un auteur a la piste
    public function setAuteur(string $auteur): void {
        $this->auteur = $auteur;
    }
}
?>