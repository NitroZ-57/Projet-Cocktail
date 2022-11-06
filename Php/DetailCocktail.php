<?php
include("../Inclusions/Donnees.inc.php");
include("../Inclusions/Common.inc.php");







if(!isset($_GET["cocktail"])) { // aucun cokctail passe en parametre
    header('Location: ../index.php');
    exit();
}

$cocktail_name = remplace_car_accentues_et_maj($_GET["cocktail"]);
$mon_cocktail = array();

foreach($Recettes as $cockatil) {
    $titre = remplace_car_accentues_et_maj($cockatil["titre"]);
    if(strpos($titre, $cocktail_name) !== false) {
        $mon_cocktail = $cockatil;
        break;
    }
}

if(empty($mon_cocktail)) { // le cokctail est invalide
    header('Location: ../index.php');
    exit();
}

// on a trouve le cocktail on peut afficher la page


?>



<!DOCTYPE html>
<html>
<head>
    <title> Gestion de Cocktails </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../Css/common.css" />
</head>

<header>
    <a href="../index.php"> <input type="button" value="Retour" /> </a>
</header>


<main>
<pre>
<?php
print_r($mon_cocktail); // TODO BETTER
?>
</pre>
</main>

<?php 
include("../Inclusions/footer.html");
?>
</html>