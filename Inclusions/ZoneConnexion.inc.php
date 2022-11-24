



<?php


if(!$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte
?>


<!-- L'UTILISATEUR N'EST PAS CONNECTE -->
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Connexion" class="header-form"> 
    Login : <input type="text" name="login" />
    Mot de Passe : <input type="password" name="mot de passe" />
    <input type="submit" name="page" value="Se Connecter">
</form>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Inscription" class="header-form">
    <input type="submit" name="page" value="Inscription" />
</form>




<?php
}
else {
    
?>

<!-- L'UTILISATEUR EST CONNECTE -->
<span id="user-name"> <?php echo $_SESSION["utilisateur"]["nom"]; ?> </span>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Profil" class="header-form">
    <input type="submit" name="page" value="Profil" />
</form>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Deconnexion" class="header-form">
    <input type="submit" name="page" value="Se deconnecter" />
</form>

<?php
}

/*
Traiter les donnees


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