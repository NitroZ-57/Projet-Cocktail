<?php

if (isset($_POST['inscription'])){
    @$sortie =  creation_utilisateur($_POST['login'], $_POST['mot_de_passe'], $_POST['nom'], $_POST['prenom'], $_POST['sexe'], $_POST['naissance']);
    echo $sortie;
}

function creation_utilisateur($login, $mdp, $nom, $prenom, $sexe, $naissance){
    
    $loginverif = verification_login($login);
    $nomverif = verification_nom_prenom($nom);
    $prenomverif = verification_nom_prenom($prenom);

    if (!($loginverif == "ok")) return $loginverif;
    if (!($nomverif == "ok")) return $nomverif;
    if (!($prenomverif == "ok")) return $prenomverif;

    $path = __DIR__ ."\\utils\\".$login.".txt";

    $file = fopen($path, 'w');

    if ($file === false ) return "erreur lors de l'ouverture du fichier de sauvegarde : ".$file; //gestion erreurs ?

    $sess = session_id();

    $mdp = password_hash($mdp, PASSWORD_DEFAULT);

    fprintf($file, 
    "login : %s\n
mot de passe haché : %s\n
id de session : %s\n
nom : %s\n
prénom : %s\n
sexe : %s\n
date de naissance : %s\n\n", $login, $mdp, $sess, $nom, $prenom, $sexe, $naissance);
//le double \n est intentionnel, pour faciliter la sauvegarde des favoris

    fclose($file);

    $_SESSION["utilisateur"]['login'] = $login;

    $_SESSION["utilisateur"]["est_connecte"] = true;

    $_SESSION["utilisateur"]['nom'] = $nom;

    $_SESSION["utilisateur"]['prenom'] = $prenom;

    $_SESSION["utilisateur"]['sexe'] = $sexe;

    $_SESSION["utilisateur"]['naissance'] = $naissance;

    foreach($_SESSION['favories'] as $fav){

        $nom_cocktail = nom_du_cocktail($recette["titre"]);

        if(!isset($_SESSION["utilisateur"]["favories"][$nom_cocktail])) { // la cle existe deja
            $_SESSION["utilisateur"]["favories"][$nom_cocktail] = $fav;
        }
        
}

    return "utilisateur enegistré avec succès";

}

    /* TRAITER ICI LE FORMULAIRE D'INSCRIPTION DANS 
    Inscription.inc.php dans le fichier [Header] */

?>