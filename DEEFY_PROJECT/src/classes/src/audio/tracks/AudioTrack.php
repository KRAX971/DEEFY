<?php
namespace iutnc\deefy\audio\tracks;
use iutnc\deefy\exception\InvalidPropertyValueException;
use iutnc\deefy\exception\InvalidPropertyNameException;
/**
 * Classe abstraite AudioTrack
 * 
 * Représente la structure de base commune à toutes les pistes audio (albums, podcasts, etc.).
 * Elle définit les attributs généraux (titre, genre, durée, nom du fichier audio)
 * et implémente la méthode __toString() pour exporter les propriétés de la piste au format JSON.
 */



abstract class AudioTrack {
    protected string $titre;
    protected ?string $genre = null;
    protected ?int $duree = null;
    protected string $nomFichier;
    protected ?string $artiste = null;


    public function __construct(string $titre, string $chemin) {
        $this->titre = $titre;
        $this->nomFichier = $chemin;
    }

     public function __get(String $att):mixed{
     if (property_exists($this,$att)){
            return $this->$att;
     }
        throw new InvalidPropertyNameException("non existante". $att);
    }

    public function setGenre(string $genre):void{
        $this->genre=$genre;
    }

    public function setDuree(int $duree): void {
        if ($duree < 0) {
            throw new InvalidPropertyValueException("Durée invalide : " . $duree);
        }
        $this->duree = $duree;
    }
    
    public function setArtiste(String $nom):void{
        $this->artiste=$nom;
    }
    public function __toString(): string {
      return json_encode(get_object_vars($this));
    }
}

?>