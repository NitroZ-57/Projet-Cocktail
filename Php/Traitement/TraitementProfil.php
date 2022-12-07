<?php

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