<form method="post">
    <fieldset>
        <input type="text" name="Recherche"/>
        <input type="submit" value="Rechercher" />
    </fieldset>
</form>
<?php
include "Donnees.inc.php";
//TODO traitement des doublons (avec + et -) en entrée à faire?
    $finalTab = array();
    if(isset($_POST['Recherche'])) {

        //ÉLIMINATION DES ESPACES, MOTS COMPOSÉS, MOTS VIDES...
        $tab = explode(" ",$_POST['Recherche']); //on convertit la recherche en tableau de mots à traiter en séparant par espaces
        
        
        $quote = false; //boolean qui indique si un mot composé a commencé à être parcouru
        $decalage = 0; //decalage que l'on doit effectuer s'il y a un mot invalide
        foreach($tab as $indice => $mot) {
            $Tchar = str_split($mot); //on convertit le mot traité en tableau de ses caractères
            if($quote) {
                $decalage++; //on décale le mot actuel donc on incrémente cette variable
                $finalTab[$indice-$decalage] = $finalTab[$indice- $decalage]." ".trim($mot, " "); //on ajoute le mot actuel au début de son mot composé
                if(in_array('"', $Tchar)) { //si l'on trouve une deuxieme quote --> fin du mot composé
                    $quote = false;
                    $finalTab[$indice - $decalage] = str_replace('"', "", $finalTab[$indice - $decalage]); //on enleve la quote du mot
                }
            }
            else {
                if(in_array('"', $Tchar)) { //si l'on trouve une première quote --> debut de mot composé
                    $quote = true;
                }
                $motfinal = trim($mot, " ");
                if(!empty($mot) && !in_array($motfinal, $finalTab)) { //on traite les mots non vides
                    $finalTab[$indice - $decalage] = $motfinal;
                }
                else { //si le mot est vide on décale tous les mots suivants
                    $decalage++;
                }
            }
        }
    ?>


    <?php //affichage
        echo "tableau d'elements à traiter : "; print_r($tab); 
    ?>
    <br />
    <?php //affichage
        echo "tableau d'elements coherents : "; print_r($finalTab);
    ?>
    <br />


    <?php 
        
        $IngSouhaites = array();
        $IngNonSouhaites = array();
        $IngInvalides = array();
        foreach($finalTab as $ingredient) {
            //ACCES ET VERIFICATION DES ALIMENTS ENTRES DANS LA BARRE DE RECHERCHE
            $ing = trim($ingredient, "-+"); //on récupère le nom de l'ingrédient
            $valide = false; //on part du principe que l'ingrédient n'est pas valide
            foreach($Hierarchie as $aliment => $tabAliments) {
                if($ing == $aliment) {
                    $valide = true; //si l'ingrédient est contenu dans la hiérarchie, alors il est valide

                    //on traite le fait que l'ingrédient soit souhaité ou non
                    $chaine = str_split($ingredient);
                    if($chaine[0] == "-") {
                        $IngNonSouhaites[] = trim($ingredient, "-");
                    }
                    else {
                        $IngSouhaites[] = trim($ingredient, "+");
                    }
                }
            }
            if($valide == false) { //si l'ingrédient n'a pas été trouvé, alors il est invalide
                $IngInvalides[] = $ingredient;
            }
        }   
    ?>
    <br />
    <?php //affichage
        if($quote == true) { //si l'on est entré dans un mot composé mais qu'on ne l'a pas fermé
            echo "Problème de syntaxe dans votre requête : nombre impair de double-quotes";
        }
        else if(empty($IngNonSouhaites) && empty($IngSouhaites)) { //si l'on a pas de critère de recherche valide
            echo "Problème dans votre requête : recherche impossible";
        }
        else {
    ?>
        <?php echo "Liste des aliments souhaités : "; foreach($IngSouhaites as $ingredient) echo $ingredient.", "; ?>
        <br />
        <?php echo "Liste des aliments non souhaités : "; foreach($IngNonSouhaites as $ingredient) echo $ingredient.", "; ?>
        <br />
        <?php echo "Liste des aliments invalides : "; foreach($IngInvalides as $ingredient) echo $ingredient.", "; ?>
        <?php 
        }
        ?>
        <br /><br />
        <?php
        //TRAITEMENT DES RECETTES
        echo "Recettes correspondantes : "; //affichage
        $RecettesValides = array();
        $indice = 0;
        $nbIngTotal = count($IngSouhaites);
        //echo $nbIngTotal;
        foreach($IngSouhaites as $ingredient) {
            foreach($Recettes as $Recette) {
                if(in_array($ingredient, $Recette["index"])) {//dans le cas où l'aliment est une feuille du tableau Hiérarchie
                    echo $Recette["titre"].", ";
                    
                    $indiceValide = -1; //la recette est par défaut absente des recettes déjà trouvées (-1 -> absente)
                    foreach($RecettesValides as $indiceRecette => $RecetteValide) {
                        if($RecetteValide["Cocktail"] == $Recette) { //si la recette en question a déjà été trouvée
                            $indiceValide = $indiceRecette;
                        }
                    }

                    if($indiceValide == -1) { //si c'est la première fois qu'on trouve la recette
                        $RecettesValides[$indice]["Cocktail"] = $Recette; //on ajoute la recette à la liste de résultats
                        $RecettesValides[$indice]["nbIngredientsRecherches"] = 1; //on initialise à 1
                        $indice++;
                    }
                    else {
                        $RecettesValides[$indiceValide]["nbIngredientsRecherches"]++; //sinon on peut accéder au nombre d'ingrédients présents et on incrémente ce nombre
                    }
                }
                
                /*
                else if(isset($Hierarchie[$ingredient]["sous-categorie"])) { //dans le cas où l'aliment n'est pas une feuille (il faut traiter toutes ses sous-catégories) //TODO
                    foreach($Hierarchie[$ingredient]["sous-categorie"] as $sousIngredient) {
                        if(in_array($sousIngredient, $Recette["index"])) {

                        } 
                        
                    }
                    while

                }
                */
            }
        }

    } 
    ?>
    <br /><br />
<?php //affichage
    foreach($RecettesValides as $Recette) {
        echo $Recette["Cocktail"]["titre"]
        .", nbIngredientsRecherches :".$Recette["nbIngredientsRecherches"]
        .", pourcentage de satisfaction : ".number_format(($Recette["nbIngredientsRecherches"] * 100) / $nbIngTotal,2)."%";
        ?><br /><?php
    }
?>


<?php
/* NOTES :
si une recette contient un ingrédient "-", son score passe directement à 0 %


0 =>
    array (
    "Cocktail" => array (
            'titre' => 'Alerte à Malibu (cocktail de la couleurs des fameux maillots de bains... ou presque)',
            'ingredients' => '50 cl de malibu coco|50 cl de gloss cerise|1 l de jus de goyave blanche|1 poignée de griottes',
            'preparation' => 'Mélanger tous les ingrédients ensemble dans un grand pichet. Placer au frais au moins 3 heures avant de déguster. Tchin tchin !!',
            'index' => 
            array (
                0 => 'Malibu',
                1 => 'Cerise',
                2 => 'Jus de goyave',
                3 => 'Cerise griotte',
            ),
        ),
    "nbIngredientsRecherches" => x;
    )

Pour calculer le score, on stockerai le nb total d'ingredients et on ferait:
($RecettesValides[indice]["nbIngredientsRecherches"] * 100) / nbTotalIng
*/
?>
