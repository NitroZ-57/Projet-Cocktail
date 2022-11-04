<?php
session_start();
include("Php/Inclusions/Donnees.inc.php");


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
        include("Php/Inclusions/ZoneConnexion.php");
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



<footer>
    <i> Made by Comte Quentin, Perin nicolas & Polkowski romain </i>
</footer>

</html>