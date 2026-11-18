<?php
namespace iutnc\deefy\loader;

 class Psr4Loader{
    private string $prefix;
    private string $chemin;

    public function __construct (String $prefix,String $chemin){
        $this->prefix = $prefix;
        $this->chemin=$chemin;
    }

      public function loadClass(string $nomClasse): void {
        if(strpos($nomClasse,$this->prefix)===0){

            //on garde le nom de la classe
            //routourne la chaine a la position strlen
            $classe = substr($nomClasse,strlen($this->prefix));

            //on cree un chemin relatif
            $cheminRe=str_replace('\\','/',$classe);

            //on fait le chemin vers la classe
            $cheminFichier = $this->chemin .'/'.$cheminRe.'.php';
            //verif de l'existance 
            if(is_file($cheminFichier)){
                require_once $cheminFichier;
            }
        }
    }
    public function register(): void{
        spl_autoload_register([$this,'loadClass']);
    }
}
?>