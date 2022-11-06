<?php
session_start();
include("Inclusions/Donnees.inc.php");


?>


<!DOCTYPE html>
<html>
<head>
    <title> Gestion de Cocktails </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="Css/common.css" />
</head>

<header>

    <form action="<?php $_SERVER['PHP_SELF'] ?>"> 
        <input type="submit" value="Navigation" name="navigation" />
        <input type="button" value="Recettes favories" name="recettes favories"/>
        Recherche : <input type="text" value="" name="recherche" />
        <input type="submit" value="Valider" name="valider"/>
    </form>

<?php
        include("Inclusions/ZoneConnexion.php");
?>


</header>

<nav>
    <h3> Aliment courant </h3>
    <!-- TODO -->
    <h4> Sous-catégories </h4>
    <!-- TODO -->
</nav>


<main>
    <h3> Liste des Cocktails </h3>
    <!-- TODO -->
</main>

<?php 
include("Inclusions/footer.html");
?>
</html>