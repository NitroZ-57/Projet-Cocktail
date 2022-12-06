<main>
<?php

if(!$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecté
        afficher_recettes($_SESSION["favories"], false);
} 
else { // si l'utilisateur est connecté
    if(isset($_SESSION["utilisateur"]["favories"]))
        afficher_recettes($_SESSION["utilisateur"]["favories"], false);
}

?>
</main>