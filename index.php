<?php session_start(); ?>


<!DOCTYPE html>
<html>

<head>
    <title> Gestion de Cocktails </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" media="screen" type="text/css" title="style" href="Css/common.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
</head>

<body>
    
<?php // INCLUSION DES TRAITEMENTS
include("Php/Common.inc.php");
include("Php/Traitement/traitementInscription.php");
include("Php/Traitement/traitementLogin.php");
include("Php/Traitement/traitementRecherche.php");
?>
    <header>
    <?php
        // récupération de toutes les parties d'entête 
        include("Php/Header/headerNavigation.inc.php");
        include("Php/Header/headerRecettesFavorites.inc.php");
        include("Php/Header/headerRecherche.inc.php");
        include("Php/Header/headerZoneConnexion.inc.php");
    ?>
    </header>


<?php
// On affiche le bon main en fonction de la page sur laquelle on est
if(!isset($_GET["page"])) {
    $_GET["page"] = "Navigation";
}
if($_GET["page"] === "Navigation") {
    include("Php/MainNav/Navigation.inc.php");
}
elseif($_GET["page"] === "🔎") {
    include("Php/MainNav/Recherche.inc.php");
}
elseif($_GET["page"] === "Recettes ❤️") {
    include("Php/MainNav/RecettesFavorites.inc.php");
}
elseif($_GET["page"] === "Inscription") {
    include("Php/MainNav/Inscription.inc.php");
}
elseif($_GET["page"] === "Profil") {
    include("Php/MainNav/Profil.inc.php");
}
else {
    include("Php/MainNav/DetailCocktail.inc.php");
}
?>

<footer>
    <i> Made by Comte Quentin, Perin Nicolas & Polkowski Romain </i>
</footer>

</body>

</html>