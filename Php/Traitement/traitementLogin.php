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
//include("../Common.inc.php");

function connexion_utilisateur($login, $mdp){
    $path = __DIR__ ."\\utils\\".$login.".txt";

    $file = fopen($path, 'r');
    if ($file === false) return "le login est incorrect ou l'utilisateur n'existe pas";

    fgets($file); //pour décaler à la ligne suivante
    fgets($file); //pour décaler à la ligne suivante

    $hashed_mdp = fgets($file);
    $hashed_mdp = trim(substr($hashed_mdp, strpos($hashed_mdp, ':') + 2));

    if (password_verify($mdp, $hashed_mdp) != true) return "mot de passe incorrect";

    $_SESSION['utilisateur']['login'] = $login;

    fgets($file); //pour décaler à la ligne suivante
    $nom = fgets($file);
    $_SESSION['utilisateur']['nom'] = trim(substr($nom, strpos($nom, ':') + 2)); // strpos + 2 car on saute le : et l'espace

    fgets($file); //pour décaler à la ligne suivante
    $prenom = fgets($file);
    $_SESSION['utilisateur']['prenom'] = trim(substr($prenom, strpos($prenom, ':')) + 2);

    fgets($file); //pour décaler à la ligne suivante
    $sexe = fgets($file);
    $_SESSION['utilisateur']['sexe'] = trim(substr($sexe, strpos($sexe, ':') + 2)); //si sexe reste un string et n'est pas un bool

    fgets($file); //pour décaler à la ligne suivante
    $naissance = fgets($file);
    $_SESSION['utilisateur']['naissance'] = trim(substr($naissance, strpos($naissance, ':') + 2));

    $_SESSION['utilisateur']['est_connecte'] = true;

    fgets($file); //pour décaler à la ligne suivante

    $tempfav = array();
    $_SESSION["utilisateur"]['favories'] = array();

    $tempfav = unserialize(fgets($file));
    
    foreach($tempfav as $nom_fav){

        $recette = recuperer_cocktail_avec_nom($Recettes, $nom_fav)

        $nom_cocktail = nom_du_cocktail($recette["titre"]);

        $_SESSION["utilisateur"]['favories'][$nom_cocktail] = $recette;
    }

    foreach($_SESSION['favories'] as $fav){

            $nom_cocktail = nom_du_cocktail($fav["titre"]);

            if(!isset($_SESSION["utilisateur"]["favories"][$nom_cocktail])) { // la cle existe deja
                $_SESSION["utilisateur"]["favories"][$nom_cocktail] = $fav;
            }
            
    }
    
}

function deconnexion_utilisateur(){

    $tempfav = array();

    foreach($_SESSION["utilisateur"]['favories'] as $fav){
        array_push($tempfav, $fav);
    }

    $path = __DIR__ ."\\utils\\".$_SESSION["utilisateur"]['login'].".txt";

    file_put_contents($path, serialize($tempfav));

    $_SESSION["utilisateur"]["est_connecte"] = false;

    $_SESSION["utilisateur"]['login'] = "";

    $_SESSION["utilisateur"]['nom'] = "";

    $_SESSION["utilisateur"]['prenom'] = "";

    $_SESSION["utilisateur"]['sexe'] = "";

    $_SESSION["utilisateur"]['naissance'] = "";

    $_SESSION["utilisateur"]['favories'] = array();

    $_SESSION['favories'] = array();

}

?>