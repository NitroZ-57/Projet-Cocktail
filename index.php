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
if(!isset($_SESSION["favories"])) 
    $_SESSION["favories"] = array();
if(!isset($_SESSION["utilisateur"])) {
    $_SESSION["utilisateur"] = array();
    $_SESSION["utilisateur"]["est_connecte"] = false;
}
if(!isset($_SESSION["utilisateur"]["favories"])) 
    $_SESSION["utilisateur"]["favories"] = array();

?>
<header>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Navigation"> 
        <input type="submit" value="Navigation" name="page" />
    </form>
    
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Recettes Favorites">
        <input type="submit" value="Recettes Favorites" name="page" />
    </form>

    <form  action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Recherche">
        Recherche : <input type="text" value="" name="Recherche" />
        <input type="submit" value="Recherche" name="page"/>
    </form>
<?php
        include("Inclusions/ZoneConnexion.inc.php");
?>


</header>

<?php
if(!isset($_GET["page"])) {
    include("Inclusions/Menu.inc.php");
}

elseif($_GET["page"] === "Navigation") {
    include("Inclusions/Navigation.inc.php");
}
elseif($_GET["page"] === "Recherche") {
    include("Inclusions/Recherches.inc.php");
}
elseif($_GET["page"] === "Recettes Favorites") {
    include("Inclusions/RecettesFavorites.inc.php");
}

else {
    include("Inclusions/DetailCocktail.inc.php");
}
?>

<footer>
    <i> Made by Comte Quentin, Perin nicolas & Polkowski romain </i>
</footer>
</html>