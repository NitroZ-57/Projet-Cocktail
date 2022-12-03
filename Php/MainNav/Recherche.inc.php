<main> 
<?php
?>
<h3> Infos recherche </h3>
<?php
    $recettes_recherchees = faire_recherche($_GET["Recherche"], $Hierarchie, $Recettes);
?>
    <h3> Liste des Cocktails </h3>
<?php
    afficher_recettes($recettes_recherchees, false);
?> 
</main>
