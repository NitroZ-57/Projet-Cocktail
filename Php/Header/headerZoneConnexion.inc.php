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
?>