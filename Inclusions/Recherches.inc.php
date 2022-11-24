<form method="post">
    <fieldset>
        <input type="text" name="Recherche"/>
        <input type="submit" value="Rechercher" />
    </fieldset>
</form>
<?php
    function retourLigne() {//fonction à utiliser dans les blocs php
        ?> <br /><?php
    }

    function TraitementRecherche($recherche) {
        //ÉLIMINATION DES ESPACES, MOTS COMPOSÉS, MOTS VIDES...
        $finalTab = array();
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
        if($quote == true) { //si l'on est entré dans un mot composé mais qu'on ne l'a pas fermé
            echo "Problème de syntaxe dans votre requête : nombre impair de double-quotes";
        }
        return $finalTab;
    }


    function verifRecherche($tabRecherche, $Hierarchie, &$IngSouhaites, &$IngNonSouhaites, &$IngInvalides) {
        foreach($tabRecherche as $ingredient) {
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
    }

    function AfficherIngResultat($ingsouhaites, $ingnonsouhaites, $inginvalides) {
        if(empty($ingnonsouhaites) && empty($ingsouhaites)) { //si l'on a pas de critère de recherche valide
            echo "Problème dans votre requête : recherche impossible";
        }
        else {
            echo "Liste des aliments souhaités : "; foreach($ingsouhaites as $ingredient) echo $ingredient.", ";
            retourLigne();
            echo "Liste des aliments non souhaités : "; foreach($ingnonsouhaites as $ingredient) echo $ingredient.", ";
            retourLigne();
            echo "Liste des aliments invalides : "; foreach($inginvalides as $ingredient) echo $ingredient.", "; 
        }
    }

    function ajoutIngRecherche($Ingredient, $Hierarchie, &$TabTotalIngs) {
        if(!empty($Hierarchie[$Ingredient]['sous-categorie'])) { //si l'aliment a des sous categories, on les évalue
            foreach($Hierarchie[$Ingredient]["sous-categorie"] as $sousIngredient) {
                ajoutIngRecherche($sousIngredient, $Hierarchie, $TabTotalIngs); //on ajoute récursivement toutes les sous-catégories
            }
        }
        if(!in_array($Ingredient, $TabTotalIngs)) {
            $TabTotalIngs[] = $Ingredient;
        }
    }

    function ensIngRecherche($IngredientsRecherche, $Hierarchie) {
        $TabTotalIngs = array();
        foreach($IngredientsRecherche as $ingredient) {
            ajoutIngRecherche($ingredient, $Hierarchie, $TabTotalIngs);
        }
        return $TabTotalIngs;
    }

    function BlacklisterRecettes($ingredients, $recettes) {
        $RecettesBlacklist = array();
        foreach($ingredients as $ingredient) { //pour tous les ingrédients non souhaités
            foreach($recettes as $recette) {
                if(in_array($ingredient, $recette["index"])) {//si l'aliment est ingrédient de la recette
                    $RecettesBlacklist[] = $recette; //alors on l'ajoute à la liste des recettes à ne pas afficher en résultat
                }
            }
        }
        return $RecettesBlacklist;
    }

    //procédure qui ajoute la recette si elle contient ingredient dans le tableau recettesValides
    function RecettesResultatRecherche($recettes, $recettesBlacklist, $TotalIngredientsSouhaites) {
        $recettesValides = array();
        $indiceRecettesValides = 0;
        foreach($recettes as $recette) {
            if(!in_array($recette, $recettesBlacklist)) {
                foreach($recette["index"] as $aliment) {
                    $nbAliments = count($recette["index"]);
                    if(in_array($aliment, $TotalIngredientsSouhaites)) {
                        $indiceValide = -1; //la recette est par défaut absente des recettes déjà trouvées (-1 -> absente)
                        foreach($recettesValides as $indiceRecette => $RecetteValide) {
                            if($RecetteValide["Cocktail"] == $recette) { //si la recette en question a déjà été trouvée
                                $indiceValide = $indiceRecette;
                            }
                        }
                        
                        if($indiceValide == -1) { //si c'est la première fois qu'on trouve la recette
                            $recettesValides[$indiceRecettesValides]["Cocktail"] = $recette; //on ajoute la recette à la liste de résultats
                            $recettesValides[$indiceRecettesValides]["score"] = 1/$nbAliments*100; //on initialise à 1
                            $indiceRecettesValides++;
                        }
                        else {
                            $recettesValides[$indiceValide]["score"] += 1/$nbAliments*100; //sinon on peut accéder au nombre d'ingrédients présents et on incrémente ce nombre
                        }
                    }
                }
            }
        }
        return $recettesValides;
    }

include "Donnees.inc.php";
    if(isset($_POST['Recherche'])) {
        $tabRecherche = TraitementRecherche($_POST['Recherche']); //on récupère les aliments de la recherche
        
        //affichage
        echo "tableau d'elements : "; print_r($tabRecherche);
        retourLigne();
        
        $IngSouhaites = array();
        $IngNonSouhaites = array();
        $IngInvalides = array();

        verifRecherche($tabRecherche, $Hierarchie, $IngSouhaites, $IngNonSouhaites, $IngInvalides);

        retourLigne();
        //affichage
        AfficherIngResultat($IngSouhaites, $IngNonSouhaites, $IngInvalides);
        
        retourLigne();
        //TRAITEMENT DES RECETTES
        
        $TotalIngredientsSouhaites = ensIngRecherche($IngSouhaites, $Hierarchie);
        $TotalIngredientsNonSouhaites = ensIngRecherche($IngNonSouhaites, $Hierarchie);
        $RecettesBlacklist = BlacklisterRecettes($TotalIngredientsNonSouhaites, $Recettes);
        
        $RecettesValides = RecettesResultatRecherche($Recettes, $RecettesBlacklist, $TotalIngredientsSouhaites);
        array_multisort(array_column($RecettesValides, 'score'), SORT_DESC, $RecettesValides); //tri des recettes TODO

        //affichage
        foreach($RecettesValides as $Recette) {
            $nbIngRecette = count($Recette["Cocktail"]["index"]);
            echo number_format($Recette["score"], 2)."% de satisfaction 
            <----- ".$Recette["Cocktail"]["titre"];
            retourLigne();
        }
    }
?>