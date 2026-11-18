<?php
namespace iutnc\deefy\render;
/**
 * Interface Renderer
 * 
 * Définit le contrat d'affichage HTML pour les différents éléments audio de l'application.
 * Elle fournit deux constantes définissant les modes d'affichage disponibles :
 * - COMPACT (1) : pour un affichage synthétique en liste
 * - LONG (2)    : pour un affichage complet avec lecteur audio
 */
interface Renderer {
    
    public const COMPACT = 1;
    public const LONG = 2;

    public function render(int $selector): string;

}