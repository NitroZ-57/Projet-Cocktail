<?php

if (isset($_POST['inscription'])){
    @$sortie =  creation_utilisateur($_POST['login'], $_POST['mot_de_passe'], $_POST['nom'], $_POST['prenom'], $_POST['sexe'], $_POST['naissance']);
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET["page"] = "Navigation";
    unset($_POST["inscription"]);
}

/* 
    Crée un utilisateur avec les arguments passés en paramètres, en vérifiant si le login et le nom/prénom sont conformes au format et la syntaxe attendus
    Crée un fichier associé à l'utilisateur, y enregistre les données et initialise les variables de session de l'utilisateur
    Transfère également les favoris sélectionnés lorsque l'utilisateur n'était pas connecté vers ses favoris personnels
*/
function creation_utilisateur($login, $mdp, $nom, $prenom, $sexe, $naissance){
    
    $loginverif = verification_login($login);
    $nomverif = verification_nom_prenom($nom);
    $prenomverif = verification_nom_prenom($prenom);

    if (!($loginverif == "ok")) return $loginverif;
    if (!($nomverif == "ok")) return $nomverif;
    if (!($prenomverif == "ok")) return $prenomverif;

    //$path = __DIR__ ."\\utils\\".$login.".txt";

    $path = realpath("Sauvegardes\\");
    $path = $path."\\".$login.".txt";

    $file = fopen($path, 'w');

    if ($file === false ) return "erreur lors de l'ouverture du fichier de sauvegarde : ".$file; //gestion erreurs ?

    $mdp = password_hash($mdp, PASSWORD_DEFAULT);

    fprintf($file, 
    "login : %s\n
mot de passe haché : %s\n
nom : %s\n
prénom : %s\n
sexe : %s\n
date de naissance : %s\n\n", $login, $mdp, $nom, $prenom, $sexe, $naissance);
//le double \n est intentionnel, pour faciliter la sauvegarde des favoris

    fclose($file);

    $_SESSION["utilisateur"]['login'] = $login;

    $_SESSION["utilisateur"]["est_connecte"] = true;

    $_SESSION["utilisateur"]['nom'] = $nom;

    $_SESSION["utilisateur"]['prenom'] = $prenom;

    $_SESSION["utilisateur"]['sexe'] = $sexe;

    $_SESSION["utilisateur"]['naissance'] = $naissance;

    $_SESSION["utilisateur"]['hash'] = $mdp;

    foreach($_SESSION['favories'] as $fav){

        //$recette = recuperer_cocktail_avec_nom($Recettes, $fav['titre']);
/*
        $nom_cocktail = nom_du_cocktail($fav);

        $_SESSION["utilisateur"]["favories"][$nom_cocktail] = $fav;*/
        ajouter_favoris($fav);
        
}

    return "utilisateur enegistré avec succès";

}

    /* TRAITER ICI LE FORMULAIRE D'INSCRIPTION DANS 
    Inscription.inc.php dans le fichier [Header] */

?>