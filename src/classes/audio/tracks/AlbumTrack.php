<?php
namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack {

    protected ?string $titreAlbum = null;
    protected ?int $anneeAlbum = null;
    protected ?int $numeroAlbum = null;

    public function __construct(string $titre, string $chemin) {
        parent::__construct($titre, $chemin);
    }

    public function setTitreAlbum(string $titreAlbum): void {
        $this->titreAlbum = $titreAlbum;
    }

    public function setAnneeAlbum(int $anneeAlbum): void {
        $this->anneeAlbum = $anneeAlbum;
    }

    public function setNumeroAlbum(int $numeroAlbum): void {
        $this->numeroAlbum = $numeroAlbum;
    }
}
?>
