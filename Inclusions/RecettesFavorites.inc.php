<main>
<?php

if(!isset($_SESSION["utilisateur"]) || !$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte
    if(isset($_SESSION["favories"]))
        afficher_recettes($_SESSION["favories"]);
}
else {
    if(isset($_SESSION["utilisateur"]["favories"]))
        afficher_recettes($_SESSION["utilisateur"]["favories"]);
}



?>
</main>