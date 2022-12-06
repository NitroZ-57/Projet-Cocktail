<?php


if(!isset($_GET["page"])) { // aucun cokctail passe en parametre
    header('Location: index.php');
    exit();
}

$cocktail_parametre = remplace_car_accentues_et_maj($_GET["page"]);
$cocktail = array();

foreach($Recettes as $cocktails) {
    $titre = remplace_car_accentues_et_maj($cocktails["titre"]);
    if(strpos($titre, $cocktail_parametre) !== false) {
        $cocktail = $cocktails;
        break;
    }
}

if(empty($cocktail)) { // le cokctail est invalide on revient au menu
    header('Location: index.php');
    exit();
}

// on a trouve le cocktail on peut afficher la page
?>
<main>
<?php
$recette = array(0 => $cocktail); // on créer un tableau dans lequel notre cocktail est le seul
afficher_recettes($recette, true); 
?>
</main>
