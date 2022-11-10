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

if(empty($cocktail)) { // le cokctail est invalide
    header('Location: index.php');
    exit();
}

// on a trouve le cocktail on peut afficher la page


?>



<main>
<pre>
<?php
print_r($cocktail); // TODO BETTER
$nom_cocktail = nom_du_cocktail($cocktail["titre"]);
$nom_image = "Photos/".$nom_cocktail.".jpg";
if(!file_exists($nom_image)) 
    $nom_image = "Photos/cocktail.png";
?>
<img class="cocktail-img"  src="<?php echo $nom_image; ?>" />
</pre>
</main>
