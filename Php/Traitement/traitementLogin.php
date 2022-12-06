<?php


/*
    Connecte l'utilisateur si le login est enregistré et le mot de passe correspond
    Met à jour les variables de session et transfère les favoris sélectionnés avant la connexion s'il ne sont pas déjà présents dans les favoris de l'utilisateur en question
*/
function connexion_utilisateur($login, $mdp, $Recettes){
    //$path = __DIR__ ."\\utils\\".$login.".txt";

    $path = realpath("Sauvegardes\\");
    $path = $path."\\".$login.".txt";

    $file = fopen($path, 'r');
    if ($file === false) return "le login est incorrect ou l'utilisateur n'existe pas";

    fgets($file); //pour décaler à la ligne suivante
    fgets($file); //pour décaler à la ligne suivante

    $hashed_mdp = fgets($file);
    $hashed_mdp = trim(substr($hashed_mdp, strpos($hashed_mdp, ':') + 2));
    
    $_SESSION["utilisateur"]['hash'] = $hashed_mdp;

    if (password_verify($mdp, $hashed_mdp) != true) return "mot de passe incorrect";

    $_SESSION['utilisateur']['login'] = $login;

    fgets($file); //pour décaler à la ligne suivante
    $nom = fgets($file);
    $_SESSION['utilisateur']['nom'] = trim(substr($nom, strpos($nom, ':') + 2)); // strpos + 2 car on saute le : et l'espace

    fgets($file); //pour décaler à la ligne suivante
    $prenom = fgets($file);
    $_SESSION['utilisateur']['prenom'] = trim(substr($prenom, strpos($prenom, ':') + 2));

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

        $recette = recuperer_cocktail_avec_nom($Recettes, $nom_fav);

        $nom_cocktail = nom_du_cocktail($recette["titre"]);

        $_SESSION["utilisateur"]['favories'][$nom_cocktail] = $recette;
    }

    foreach($_SESSION['favories'] as $fav){

            $nom_cocktail = nom_du_cocktail($fav["titre"]);

            if(!isset($_SESSION["utilisateur"]["favories"][$nom_cocktail])) { // la cle existe deja
                $_SESSION["utilisateur"]["favories"][$nom_cocktail] = $fav;
                //ajouter_favoris($fav); // ça doit aussi marcher normalement
            }
            
    }
    return "connexion réussie";
    
}

/*
    Déconnecte l'utilisateur actuel en enregistrant ce qu'il a fait comme modification dans ses favoris ou son profil pendant la session
    Remet les variables de session à zéro
*/
function deconnexion_utilisateur(){

    $tempfav = array();

    foreach($_SESSION["utilisateur"]['favories'] as $fav){
        array_push($tempfav, $fav['titre']);
    }

    //$path = __DIR__ ."\\utils\\".$_SESSION["utilisateur"]['login'].".txt";

    $path = realpath("Sauvegardes\\");
    $path = $path."\\".$_SESSION["utilisateur"]['login'].".txt";

    $file = fopen($path, 'w');

    fprintf($file, 
    "login : %s\n
mot de passe haché : %s\n
nom : %s\n
prénom : %s\n
sexe : %s\n
date de naissance : %s\n\n", $_SESSION["utilisateur"]['login'], $_SESSION["utilisateur"]['hash'], $_SESSION["utilisateur"]['nom'], $_SESSION["utilisateur"]['prenom'], $_SESSION["utilisateur"]['sexe'], $_SESSION["utilisateur"]['naissance']);
//le double \n est intentionnel, pour faciliter la sauvegarde des favoris

    fclose($file);

    file_put_contents($path, serialize($tempfav), FILE_APPEND);

    $_SESSION["utilisateur"]["est_connecte"] = false;

    $_SESSION["utilisateur"]['login'] = "";

    $_SESSION["utilisateur"]['nom'] = "";

    $_SESSION["utilisateur"]['prenom'] = "";

    $_SESSION["utilisateur"]['sexe'] = "";

    $_SESSION["utilisateur"]['naissance'] = "";

    $_SESSION["utilisateur"]['favories'] = array();

    $_SESSION['favories'] = array();

    return "deconnexion réussie";

}



if (isset($_POST['page']) && $_POST['page'] == "Se Connecter"){
    @$sortie =  connexion_utilisateur($_POST['login'], $_POST['mot_de_passe'], $Recettes);
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET['page'] = "Navigation";
}

if (isset($_POST['page']) && $_POST['page'] == "Se Deconnecter"){
    @$sortie =  deconnexion_utilisateur();
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET['page'] = "Navigation";
}


?>