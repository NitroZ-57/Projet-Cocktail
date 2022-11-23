<?php
// à debugger
include("Common.inc.php");
foreach($Recettes as $recette) {
    if($recette["titre"] === $_POST["recette"]) {
        echo $recette["titre"];
        ajouter_favoris($recette);
        break;
    }
}


?>