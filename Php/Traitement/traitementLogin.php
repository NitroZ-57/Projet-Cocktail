<?php

/*
Traiter les donnees du fichier Login.inc.php dans le dossier [MainNav]


$_SESSION["favories"] :
    contient toutes les recettes favories quand l'utilisateur n'est pas connecte (ne pas supprimer lorsque l'utilisateur se connecte)

$_SESSION["utilisateur"] : 
    un tableau contenant les informations sur l'utilisateur

    $_SESSION["utilisateur"]["est_connecte"] :
        doit être vrai quand l'utilisateur est connecté et faux quand il se deconnecte
    
    $_SESSION["utilisateur"]["nom"] :
        le nom de l'utilisateur
    
    $_SESSION["utilisateur"]["favories"] : 
        contient toutes les recettes favories de l'utilisateur connecte (lorsqu'il se connecte il faut récupérer les recettes qu'il avait déjà en favoris lors de ses anciennes connexions)

    ...etc 


*/



?>