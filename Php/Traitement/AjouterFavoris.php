<?php

session_start();
include("../Common.inc.php");
$cocktail = recuperer_cocktail_avec_nom($Recettes, $_POST["recette"]);
if($cocktail !== false) {
    ajouter_favoris($cocktail);
}

?>