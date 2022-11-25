<script> 

function favoris_est_clique(objet, recette) { 
if( $(objet).hasClass('favoris')) {
    $(objet).removeClass('favoris');
}
else {
    $(objet).addClass('favoris');
}
$.post("Inclusions/AjouterFavoris.inc.php", {recette:recette}, function(res) { // à debugger
    //alert(res);
});
}
</script>
<?php

include("Donnees.inc.php");
include("Inclusions/Recherches.inc.php");

if(!isset($_SESSION["favories"])) 
    $_SESSION["favories"] = array();
if(!isset($_SESSION["utilisateur"])) {
    $_SESSION["utilisateur"] = array();
    $_SESSION["utilisateur"]["est_connecte"] = false;
}
if(!isset($_SESSION["utilisateur"]["favories"])) 
    $_SESSION["utilisateur"]["favories"] = array();


/*
    Retourne une chaine de caractère :
        - Remplace tous les caractères accentués d'une chaine par des caractères non accentués
        - Remplace tous les caractères majuscule d'une chaine par des caractères minuscules
        - Enlève les espaces au début et à la fin de la chaine
*/
function remplace_car_accentues_et_maj($chaine) {
    $chaine = trim($chaine);
    $foo = array(
        'à' => 'a',
        'é' => 'e',
        'è' => 'e',
        'ï' => 'i',
        'î' => 'i',
        'ô' => 'o',
        'ö' => 'o',
        'ù' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'A' => 'a',
        'B' => 'b',
        'C' => 'c',
        'D' => 'd',
        'E' => 'e',
        'F' => 'f',
        'G' => 'g',
        'H' => 'h',
        'I' => 'i',
        'J' => 'j',
        'K' => 'k',
        'L' => 'l',
        'M' => 'm',
        'N' => 'n',
        'O' => 'o',
        'P' => 'p',
        'Q' => 'q',
        'R' => 'r',
        'S' => 's',
        'T' => 't',
        'U' => 'u',
        'V' => 'v',
        'W' => 'w',
        'X' => 'x',
        'Y' => 'y',
        'Z' => 'z'
    );

    foreach($foo as $ancien => $nouveau) {
        $chaine = str_replace($ancien, $nouveau,$chaine);
    }
    return $chaine;
}

/*
    Retourne le nom d'un cocktail à partir d'un nom à rallonge (ceux donné dans les index de $Recette dans Donnees.inc.php)
*/
function nom_du_cocktail($cocktail) {
    if( preg_match('#(^[^\(]*)#i', $cocktail, $regs) ) {
        return $regs[1];
    }
    else 
        return false;
}

/*
    Retourne le nom d'une image d'un cocktail à partir d'un nom à rallonge (ceux donné dans les index de $Recette dans Donnees.inc.php)
*/
function nom_image_cocktail($cocktail) {
    if(preg_match('#(^[^\(]*)#i', $cocktail, $regs)) {
        $nom_image = "Photos/".str_replace(' ', '_',trim($regs[1])).".jpg";
        return $nom_image;
        if(file_exists($nom_image))
            return $nom_image;
        else 
            return "Photos/cocktail.png";
    }
    else
        return false;
}

/*
    Ajoute une recette aux favoris ou l'enleve si elle existe deja 
    Prends en compte si l'utilisateur est connecté ou non (si $_SESSION["utilisateur"]["est_connecte"] est vrai ou non )
        - Si oui ajoute la recette dans $_SESSION["utilisateur"]["favories"] 
        - Si non ajoute la recette dans $_SESSION["favories"] 

    A DEBUGGER
*/
function ajouter_favoris($recette) {
    $nom_cocktail = nom_du_cocktail($recette["titre"]);

    if(!$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte

        if(isset($_SESSION["favories"][$nom_cocktail])) { // la cle existe deja
            unset($_SESSION["favories"][$nom_cocktail]);
        }
        else {
            $_SESSION["favories"][$nom_cocktail] = $recette;

        }
    }
    else {
        if(isset($_SESSION["utilisateur"]["favories"])) {

            if(isset($_SESSION["utilisateur"]["favories"][$nom_cocktail])) { // la cle existe deja
                unset($_SESSION["utilisateur"]["favories"][$nom_cocktail]);
            }
            else {
                $_SESSION["utilisateur"]["favories"][$nom_cocktail] = $recette;
            }
        } 
        else {
            if(!isset($_SESSION["utilisateur"]["favories"])) 
                $_SESSION["utilisateur"]["favories"] = array();
            $_SESSION["utilisateur"]["favories"][$nom_cocktail] = $recette; 
        }
    }
}

/*
    Retourne vraie si la recette est favorie, faux sinon
    Prends en compte si l'utilisateur est connecté ou non

    A DEBUGGER
*/
function est_favorie($recette) {
    $nom_cocktail = nom_du_cocktail($recette["titre"]);
    if(!$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte
        return isset($_SESSION["favories"][$nom_cocktail]);
    }
    else {
        if(isset($_SESSION["utilisateur"]["favories"]))
            return isset($_SESSION["utilisateur"]["favories"][$nom_cocktail]);
        else 
            return false;
    }
}



/*
    Donne le code HTML pour afficher un ensemble de recette selon un tableau de recette donné en paramètre

    A DEBUGGER
*/
function afficher_recettes($recettes) {
    if(empty($recettes)) {
        ?>
        <h3> Nous n'avons trouvé aucun cocktail correspondant à votre demande. </h3>
        <?php
    }
    else {
    
    foreach($recettes as $cocktail) {
        $nom_cocktail = nom_du_cocktail($cocktail["titre"]);
        $nom_image = "Photos/".$nom_cocktail.".jpg";
        if(!file_exists($nom_image)) 
            $nom_image = "Photos/cocktail.png";
        if(isset($c))
    ?>


        <div class="cocktail-div">
            <span class="cocktail-header"> 
                <span> <?php echo $nom_cocktail; ?> </span> 
                <span class="<?php if(est_favorie($cocktail)) echo "favoris"; ?>" onclick="favoris_est_clique(this, '<?php echo $nom_cocktail; ?>' ) "> Favoris </span> 
            </span>
            <a href="<?php echo "index.php?page=".$nom_cocktail; ?>"> 
                <center> <img class="cocktail-img" src="<?php echo $nom_image; ?>" /> </center> 
            </a>
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
            <?php
                if(isset($cocktail["score"])) {
                    echo "score de ".number_format($cocktail["score"], 2)." %"; //TODO affichage à paufiner
                }
            ?>
        </div>



<?php
    }
}
}












//FONCTIONS DE LA PARTIE RECHERCHE

function retourLigne() {//fonction à utiliser dans les blocs php
    ?> <br /><?php
}

function TraitementRecherche($recherche) {
    //ÉLIMINATION DES ESPACES, MOTS COMPOSÉS, MOTS VIDES...
    $finalTab = array();
    $tab = explode(" ",$recherche); //on convertit la recherche en tableau de mots à traiter en séparant par espaces
    
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
    if(empty($IngSouhaites)) { //si l'on a pas de critère de recherche valide
        if(empty($IngNonSouhaites)) {
            echo "Problème dans votre requête : recherche impossible";
        }
        else {
            $IngSouhaites[] = "Aliment";
        }
    }
}

function AfficherIngResultat($ingsouhaites, $ingnonsouhaites, $inginvalides) {
    echo "Liste des aliments souhaités : "; foreach($ingsouhaites as $ingredient) echo $ingredient.", ";
    retourLigne();
    echo "Liste des aliments non souhaités : "; foreach($ingnonsouhaites as $ingredient) echo $ingredient.", ";
    retourLigne();
    echo "Liste des aliments invalides : "; foreach($inginvalides as $ingredient) echo $ingredient.", "; 
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
                        if($RecetteValide["titre"] == $recette["titre"]) { //si la recette en question a déjà été trouvée
                            $indiceValide = $indiceRecette;
                        }
                    }
                    
                    if($indiceValide == -1) { //si c'est la première fois qu'on trouve la recette
                        $recettesValides[$indiceRecettesValides] = $recette; //on ajoute la recette à la liste de résultats
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




/* 
    Effectue la recherche à partir d'une ligne d'entrée
    $ligne : la ligne dans l'input 
    retourne : un tableau de recettes correspondant à la recherche

*/

function faire_recherche($ligne) {
    include("Donnees.inc.php"); //TODO
    if(isset($ligne)) {
        $tabRecherche = TraitementRecherche($ligne); //on récupère les aliments de la recherche
        
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
        array_multisort(array_column($RecettesValides, 'score'), SORT_DESC, $RecettesValides); //tri des recettes
        return $RecettesValides;
        //affichage
        foreach($RecettesValides as $Recette) {
            $nbIngRecette = count($Recette["index"]);
            echo number_format($Recette["score"], 2)."% de satisfaction 
            <----- ".$Recette["titre"];
            retourLigne();
        }
    }
}
?>