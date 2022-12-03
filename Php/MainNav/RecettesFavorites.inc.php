<main>
<?php

if(!$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte
    if(isset($_SESSION["favories"]))
        afficher_recettes($_SESSION["favories"], false);
}
else {
    if(isset($_SESSION["utilisateur"]["favories"]))
        afficher_recettes($_SESSION["utilisateur"]["favories"], false);
}



?>
</main>