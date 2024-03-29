<?php

if (isset($_POST['inscription'])){
    @$sortie =  creation_utilisateur($_POST['login'], $_POST['mot_de_passe'], $_POST['nom'], $_POST['prenom'], $_POST['sexe'], $_POST['naissance']);
    if($sortie === "utilisateur enegistré avec succès")
        echo "<script> alert(\"$sortie\"); document.location.href=\"index.php?page=Navigation\"; </script>"; // cette ligne sert à afficher un message dans une boite d'alerte et revenir sur le menu pour ne pas avoir à reconfirmer le formulaire lors d'une actualisation
    else 
        echo "<script> alert(\"$sortie\"); document.location.href=\"index.php?page=Inscription\"; </script>";
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

    $path = realpath("Sauvegardes\\");
    $path = $path."\\".$login.".txt";

    $file = fopen($path, 'w');

    if ($file === false ) return "erreur lors de l'ouverture du fichier de sauvegarde : ".$file; //gestion erreurs ?

    $mdp = md5($mdp, false);

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
        ajouter_favoris($fav);
    }

    $_SESSION["favories"] = array();

    return "utilisateur enegistré avec succès";

}

?>