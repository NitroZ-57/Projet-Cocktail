<?php

if (isset($_POST['Changement_mdp'])){
    @$sortie =  modifier_mdp($_POST['nouveau_mot_de_passe']);
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET['page'] = "Profil";
}

if (isset($_POST['Changement_nom'])){
    @$sortie =  modifier_nom($_POST["nouveau_nom"]);
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET['page'] = "Profil";
}

if (isset($_POST['Changement_prenom'])){
    @$sortie =  modifier_prenom($_POST['nouveau_prenom']);
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET['page'] = "Profil";
}

if (isset($_POST['Changement_sexe'])){
    @$sortie =  modifier_sexe($_POST['nouveau_sexe']);
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET['page'] = "Profil";
}

if (isset($_POST['Changement_naissance'])){
    @$sortie =  modifier_naissance($_POST['nouvelle_naissance']);
    echo "<script> boite_alerte(\"$sortie\"); </script>";
    $_GET['page'] = "Profil";
    }

?>