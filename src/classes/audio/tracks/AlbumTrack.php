<?php
namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack {

    protected ?string $titreAlbum = null;
    protected ?int $anneeAlbum = null;
    protected ?int $numeroAlbum = null;

    //constructeur d'un albumTrack
    public function __construct(string $titre, string $chemin) {
        parent::__construct($titre, $chemin);
    }
    //insert un titre a l'album
    public function setTitreAlbum(string $titreAlbum): void {
        $this->titreAlbum = $titreAlbum;
    }
    //insert l'année de l'album
    public function setAnneeAlbum(int $anneeAlbum): void {
        $this->anneeAlbum = $anneeAlbum;
    }
    //insert le numero
    public function setNumeroAlbum(int $numeroAlbum): void {
        $this->numeroAlbum = $numeroAlbum;
    }
}
?>
