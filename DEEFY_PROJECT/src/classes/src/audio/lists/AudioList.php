<?php
namespace iutnc\deefy\audio\lists;
use iutnc\deefy\exception\InvalidPropertyNameException;
class AudioList{
    protected string $nom;
    protected int $nbPistes = 0;
    protected int $dureeTotale = 0;
    protected array $pistes = [];
    protected ?int $id = null;

    public function __construct(string $nom,array $pistes =[] ){
        $this->nom=$nom;
        $this->pistes=$pistes;
        $this->nbPistes = count($pistes);
        $this->dureeTotale =0;
        foreach($pistes as $piste){
            $this->dureeTotale += $piste->duree;
        }
    }


    public function __get(string $att): mixed {
        if (property_exists($this, $att)) {
            return $this->$att;
        }

        throw new InvalidPropertyNameException("Propriete non existante : " . $att);
    }
    public function setId(int $id): void {$this->id=$id;}
}

?>




