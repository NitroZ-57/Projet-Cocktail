<?php
session_start();
include("Inclusions/Common.inc.php");
?>


<!DOCTYPE html>
<html>
<head>
    <title> Gestion de Cocktails </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" media="screen" type="text/css" title="style" href="Css/common.css" />
</head>

<header>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" name="Navigation"> 
        <input type="submit" value="Navigation" name="page" />
        <input type="submit" value="Recettes Favorites" name="page"/>
        Recherche : <input type="text" value="" name="recherche" />
        <input type="submit" value="Recherche" name="page"/>
    </form>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Connexion">

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