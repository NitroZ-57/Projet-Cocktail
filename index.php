<?php
session_start();

?>


<!DOCTYPE html>
<html>
<head>
    <title> Gestion de Cocktails </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" media="screen" type="text/css" title="style" href="Css/common.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
</head>
<?php
include("Inclusions/Common.inc.php");

//print_r($_SESSION["favories"]);

//$_SESSION["utilisateur"]["nom"] = "Quentin";
//$_SESSION["utilisateur"]["est_connecte"] = true;

?>
<header>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Navigation" class="header-form"> 
        <input type="submit" value="Navigation" name="page" />
    </form>
    
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Recettes Favorites" class="header-form">
        <input type="submit" value="Recettes Favorites" name="page" />
    </form>

    <form  action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Recherche" class="header-form">
        Recherche : <input type="text" value="" name="Recherche" />
        <input type="submit" value="Recherche" name="page"/>
    </form>
<?php
        include("Inclusions/ZoneConnexion.inc.php");
?>


</header>

<?php
if(!isset($_GET["page"])) {
    $_GET["page"] = "Navigation";
}

if($_GET["page"] === "Navigation") {
    include("Inclusions/Navigation.inc.php");
}
elseif($_GET["page"] === "Recherche") {
    include("Inclusions/Recherches.inc.php");
    $recettes_recherchees = faire_recherche($_GET["Recherche"]);
    afficher_recettes($recettes_recherchees);
}
elseif($_GET["page"] === "Recettes Favorites") {
    include("Inclusions/RecettesFavorites.inc.php");
}
elseif($_GET["page"] === "Inscription") {
    include("Inclusions/Inscription.inc.php");
}
elseif($_GET["page"] === "Profil") {
    include("Inclusions/Profil.inc.php");
}
else {
    include("Inclusions/DetailCocktail.inc.php");
}
?>

<footer>
    <i> Made by Comte Quentin, Perin nicolas & Polkowski romain </i>
</footer>
</html>