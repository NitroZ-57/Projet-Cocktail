<?php

include("Php\Donnees.inc.php");

//laisser les traitements en haut pour faciliter le rafraichissement de la page
if (isset($_POST['page'])){
    if($_POST['page'] === "Se Connecter") {
    @$sortie =  connexion_utilisateur($_POST['login'], $_POST['mot_de_passe'], $Recettes);
    echo $sortie;
    $_GET['page'] = "Navigation";
    }
}

//echo $_SESSION['utilisateur']['login']." estconnecte : ".$_SESSION['utilisateur']['est_connecte'];

if (isset($_GET['page'])){
    if($_GET['page'] === "Se deconnecter") {
    @$sortie =  deconnexion_utilisateur();
    echo $sortie;
    //$_GET['page'] = "Navigation";
    }
}

if ($_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur est connecte
?>

<!-- L'UTILISATEUR EST CONNECTE -->
<span id="user-name"> <?php echo $_SESSION["utilisateur"]["login"]; ?> </span>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Profil" class="header-form">
    <input type="submit" name="page" value="Profil" />
</form>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Deconnexion" class="header-form">
    <input type="submit" name="page" value="Se deconnecter" />
</form>

<?php
}
else {
    
?>

<!-- L'UTILISATEUR N'EST PAS CONNECTE -->
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Connexion" class="header-form"> 
    Login : <input type="text" name="login" />
    Mot de Passe : <input type="password" name="mot_de_passe" />
    <input type="submit" name="page" value="Se Connecter">
</form>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Inscription" class="header-form">
    <input type="submit" name="page" value="Inscription" />
</form>

<?php
}
?>