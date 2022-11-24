<?php
// à debugger
session_start();
include("Common.inc.php");
foreach($Recettes as $recette) {
    if(nom_du_cocktail($recette["titre"]) === nom_du_cocktail($_POST["recette"])) {
        echo $recette["titre"];
        ajouter_favoris($recette);
        echo est_favorie($recette);
        break;
    }
    echo $recette["titre"];
}

?>