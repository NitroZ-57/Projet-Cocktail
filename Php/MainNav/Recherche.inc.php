<?php
    $recettes_recherchees = faire_recherche($_GET["Recherche"], $Hierarchie, $Recettes);
?>
<main> 
    <h3> Liste des Cocktails </h3>
<?php
    afficher_recettes($recettes_recherchees);
?> 
</main>
