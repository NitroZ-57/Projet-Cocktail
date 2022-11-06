<?php
session_start();
include("Inclusions/Donnees.inc.php");
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
<?php
foreach($Recettes as $cocktail) {
$nom_cocktail = nom_du_cocktail($cocktail["titre"]);
$nom_image = "Photos/".$nom_cocktail.".jpg";
if(!file_exists($nom_image)) 
    $nom_image = "Photos/cocktail.png";
?>


    <a href="<?php echo "Php/DetailCocktail.php?cocktail=".$nom_cocktail; ?>">
        <div class="cocktail-div">
            <span class="cocktail-header"> 
                <span> <?php echo $nom_cocktail; ?> </span> 
                <span class="favoris"> Favoris </span> 
            </span>
            <center> <img class="cocktail-img" src="<?php echo $nom_image; ?>" /> </center> 
            <ul>
<?php
    foreach($cocktail["index"] as $ingredient) {
?>
                <li> <?php echo 
                        $ingredient; 
                    ?> </li>
<?php
    }       
?>
            </ul>
        </div>
    </a>
<?php
}
?>
</main>

<?php 
include("Inclusions/footer.html");
?>
</html>