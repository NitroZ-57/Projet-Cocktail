

<?php
?>

<nav>
    <h3> Aliment courant </h3>
    <?php
        if(isset($_GET["fil"])) {
            $FilString = $_GET["fil"];
            if(isset($_GET["alimentPrecedent"])) {
                $alimentPrecedent = $_GET["alimentPrecedent"];
                $FilStringTab = explode($alimentPrecedent, $FilString);
                $FilString = $FilStringTab[0].$alimentPrecedent;
            }
            $FilTab = explode(" / ", $FilString);
            foreach($FilTab as $alim) {
                ?>
                <a href ="index.php?alimentPrecedent=<?php echo $alim ?>&fil=<?php echo $FilString ?>"><?php echo $alim ?></a>
                <?php
                echo " / ";
            }
        }
        else {
            $FilString = "Aliment";
            ?>
            <a href ="index.php?fil='Aliment /'"><?php echo "Aliment /"; ?></a>
            <?php
            
        }
    ?>
    
    <h4> Sous-catégories </h4>
    <ul>
        <?php 
        if (isset($_GET["alimentSuivant"])) { //si on a avancé 
            $alimentCourant = $_GET["alimentSuivant"];
        }
        else if(empty($alimentCourant) && isset($FilTab)){ //si on est retourné en arrière
            $nbAliments = count($FilTab);
            $alimentCourant = $FilTab[$nbAliments-1];
        }
        else {//si le fil d'Ariane est à la racine (Aliment)
            $alimentCourant = "Aliment";
        }

        if(!empty($Hierarchie[$alimentCourant]['sous-categorie'])) { //si l'aliment n'est pas une feuille
            foreach($Hierarchie[$alimentCourant]["sous-categorie"] as $aliment) { //on affiche toutes ses feuilles
                ?>
                <li><a href="index.php?alimentSuivant=<?php echo $aliment ?>&fil=<?php echo $FilString." / ".$aliment; ?>"><?php echo $aliment ?></a></li>
                <?php
            }
        }
    ?>
    </ul>
</nav>
<?php
if(isset($alimentCourant)) {
        $TabIngredients = array();
        ajoutIngRecherche($alimentCourant, $Hierarchie, $TabIngredients);
        $recettesNav = RecettesResultatRecherche($Recettes, array(), $TabIngredients);
    }
    else {
        $recettesNav = $Recettes;
    }
?>
    <main>
        <h3> Liste des Cocktails </h3>
    <?php
        afficher_recettes($recettesNav);
    ?>
    </main>