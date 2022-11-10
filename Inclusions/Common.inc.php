<?php

include("Donnees.inc.php");
$_SERVER["Recettes"] = $Recettes;
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
    $nom_complet_cocktail = $recette["titre"];


    if(!isset($_SESSION["utilisateur"]) || !$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte
        if(isset($_SESSION["favories"][$nom_cocktail])) { // la cle existe deja
            unset($_SESSION["favories"][$nom_cocktail]);
            $supprimer = true;
        }
        else {
            if(!isset($_SESSION["favories"])) 
                $_SESSION["favories"] = array();
            array_push($_SESSION["favories"], $nom_cocktail);
        }
    }
    else {
        if(isset($_SESSION["utilisateur"]["favories"])) {
            if(isset($_SESSION["utilisateur"]["favories"][$nom_cocktail])) { // la cle existe deja
                unset($_SESSION["utilisateur"]["favories"][$nom_cocktail]);
                $supprimer = true;
            }
            else {
                if(!isset($_SESSION["utilisateur"]["favories"])) 
                    $_SESSION["utilisateur"]["favories"] = array();
                array_push($_SESSION["utilisateur"]["favories"], $nom_cocktail);
            }
        } 
        else {
            if(!isset($_SESSION["utilisateur"]["favories"])) 
                $_SESSION["utilisateur"]["favories"] = array();
            array_push($_SESSION["utilisateur"]["favories"], $nom_cocktail);
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
    $nom_complet_cocktail = $recette["titre"];


    if(!isset($_SESSION["utilisateur"]) || !$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte
        return array_key_exists($nom_cocktail, $_SESSION["favories"]);
    }
    else {
        if(isset($_SESSION["utilisateur"]["favories"]))
            return array_key_exists($nom_cocktail, $_SESSION["utilisateur"]["favories"]);
        else 
            return false;
    }
}



/*
    Donne le code HTML pour afficher un ensemble de recette selon un tableau de recette donné en paramètre

    A DEBUGGER
*/
function afficher_recettes($recettes) {
    global $Recettes;
    foreach($recettes as $cocktail) {
        $nom_cocktail = nom_du_cocktail($cocktail["titre"]);
        $nom_image = "Photos/".$nom_cocktail.".jpg";
        if(!file_exists($nom_image)) 
            $nom_image = "Photos/cocktail.png";
        if(isset($c))
    ?>
    
    
        <a href="<?php echo "index.php?page=".$nom_cocktail; ?>">
            <div class="cocktail-div">
                <span class="cocktail-header"> 
                    <span> <?php echo $nom_cocktail; ?> </span> 
                    <span class="<?php if(est_favorie($cocktail)) echo "favoris"; ?>"> Favoris </span> 
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
}
?>