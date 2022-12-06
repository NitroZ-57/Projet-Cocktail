<?php
// Fichier servant à faire une requête ajax pour ajouter aux favoris lorsqu'un coeur est cliqué
session_start();
include("../Common.inc.php");
$cocktail = recuperer_cocktail_avec_nom($Recettes, $_POST["recette"]); // je recupère mon cocktail et je l'ajoute si il existe
if($cocktail !== false) {
    ajouter_favoris($cocktail);
}

?>