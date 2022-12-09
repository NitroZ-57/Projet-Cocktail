<?php

/*
    Modifie le mot de passe de l'utilisateur et le hashe bien sûr
*/
function modifier_mdp($mdp){
    $mdp = md5($mdp, false);
    $_SESSION["utilisateur"]['hash'] = $mdp;
    return "Mot de passe changé avec succès";
}

/*
    Modifie le nom s'il satisfait la syntaxe attendue
*/
function modifier_nom($nom){
    $verif = verification_nom_prenom($nom);
    if ($verif !== "ok")
        return $verif;
    
    $_SESSION["utilisateur"]['nom'] = $nom;
    return "Nom changé avec succès";
}

/*
    Modifie le prénom s'il satisfait la syntaxe attendue
*/
function modifier_prenom($prenom){
    $verif = verification_nom_prenom($prenom);
    if ($verif !== "ok")
        return $verif;
    
    $_SESSION["utilisateur"]['prenom'] = $prenom;
    return "Prénom changé avec succès";
}

/*
    Modifie le sexe s'il n'avait pas la même valeur auparavant
*/
function modifier_sexe($sexe){
    if ($sexe === $_SESSION["utilisateur"]['sexe'])
        return "Le sexe avait déjà la valeur ".$sexe.", aucun changement ne sera appliqué";
    
    else{
        $_SESSION["utilisateur"]['sexe'] = $sexe;
        return "Le sexe a correctement été changé";
    }
}

/*
    Modifie la date de naissance si elle n'avait pas la même valeur auparavant
*/
function modifier_naissance($naissance){
    if ($naissance === $_SESSION["utilisateur"]['naissance'])
        return "La date de naissance avait déjà la valeur ".$naissance.", aucun changement ne sera appliqué";
    
    else{
        $_SESSION["utilisateur"]['naissance'] = $naissance;
        return "La date de naissance a correctement été changée";
    }
}

if (isset($_POST['Changement_mdp'])){
    @$sortie =  modifier_mdp($_POST['nouveau_mot_de_passe']);
    echo "<script> alert(\"$sortie\"); document.location.href=\"index.php?page=Profil\"; </script>"; // cette ligne sert à afficher un message dans une boite d'alerte et revenir sur le menu pour ne pas avoir à reconfirmer le formulaire lors d'une actualisation
}

if (isset($_POST['Changement_nom'])){
    @$sortie =  modifier_nom($_POST["nouveau_nom"]);
    echo "<script> alert(\"$sortie\"); document.location.href=\"index.php?page=Profil\"; </script>"; // cette ligne sert à afficher un message dans une boite d'alerte et revenir sur le menu pour ne pas avoir à reconfirmer le formulaire lors d'une actualisation
}

if (isset($_POST['Changement_prenom'])){
    @$sortie =  modifier_prenom($_POST['nouveau_prenom']);
    echo "<script> alert(\"$sortie\"); document.location.href=\"index.php?page=Profil\"; </script>"; // cette ligne sert à afficher un message dans une boite d'alerte et revenir sur le menu pour ne pas avoir à reconfirmer le formulaire lors d'une actualisation
}

if (isset($_POST['Changement_sexe'])){
    @$sortie =  modifier_sexe($_POST['nouveau_sexe']);
    echo "<script> alert(\"$sortie\"); document.location.href=\"index.php?page=Profil\"; </script>"; // cette ligne sert à afficher un message dans une boite d'alerte et revenir sur le menu pour ne pas avoir à reconfirmer le formulaire lors d'une actualisation
}

if (isset($_POST['Changement_naissance'])){
    @$sortie =  modifier_naissance($_POST['nouvelle_naissance']);
    echo "<script> alert(\"$sortie\"); document.location.href=\"index.php?page=Profil\"; </script>"; // cette ligne sert à afficher un message dans une boite d'alerte et revenir sur le menu pour ne pas avoir à reconfirmer le formulaire lors d'une actualisation
}

?>