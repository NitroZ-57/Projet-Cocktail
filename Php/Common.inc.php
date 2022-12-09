<script> 

function favoris_est_clique(objet, recette) {  
if( $(objet).attr('src').localeCompare('img/coeur.png') == 1 ) { // on s'occupe de l'image du coeur 
    $(objet).attr('src', 'img/coeur.png');
}
else {
    $(objet).attr('src', 'img/coeurVide.png');
}
$.post("Php/Traitement/AjouterFavoris.php", {recette:recette}, function(res) { // on fait la requete ajax pour ajouter aux favoris en php
    
});
}


</script>
<?php

include("Donnees.inc.php");

// EMEPECHER LES VARIABLES PAS INITIALISEES
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
        'ñ' => 'n',
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
        $nom_image = remplace_car_accentues_et_maj("Photos/".str_replace(' ', '_',trim($regs[1])).".jpg");
        if(file_exists($nom_image))
            return $nom_image;
        else 
            return "Photos/cocktail.png";
    }
    else
        return false;
}



/*
    Retourne le cocktail entier associé à un nom à rallonge (ceux donné dans les index de $Recette dans Donnees.inc.php)
    Retourne faux si rien n'a été trouvé
*/
function recuperer_cocktail_avec_nom($Recettes, $nom) {
    foreach($Recettes as $recette) {
        if(remplace_car_accentues_et_maj($recette["titre"]) === remplace_car_accentues_et_maj($nom)) {
            return $recette;
        }
    }
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
    $nom_cocktail = $recette["titre"];
    if(!$_SESSION["utilisateur"]["est_connecte"]) { // si l'utilisateur n'est pas connecte

        if(isset($_SESSION["favories"][$nom_cocktail])) { // la cle existe deja
            unset($_SESSION["favories"][$nom_cocktail]);echo "<script> alert('$nom_cocktail'); </script>";
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
    $nom_cocktail = $recette["titre"];
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
function afficher_recettes($recettes, $detail) {
    if(empty($recettes)) {
        ?>
        <h3> Nous n'avons trouvé aucun cocktail correspondant à votre demande. </h3>
        <?php
    }
    else {
    
    foreach($recettes as $cocktail) {
        $nom_cocktail = $cocktail["titre"];
        $nom_image = nom_image_cocktail(nom_du_cocktail($nom_cocktail));
        if(isset($c))
    ?>


        <div class="cocktail-div">
            <span class="cocktail-header"> 
                <a href="<?php echo "index.php?page=".$nom_cocktail; ?>" title="cliquer pour plus de details"> 
                    <span> <?php echo nom_du_cocktail($nom_cocktail); ?> </span> 
                </a>
                <img src="<?php if(est_favorie($cocktail)) echo "img/coeur.png"; else echo "img/coeurVide.png"?>" onclick="favoris_est_clique(this, '<?php echo $nom_cocktail; ?>' ) " class="icon" title="favoris"/>  
            </span>
            <center> <img class="cocktail-img" src="<?php echo $nom_image; ?>" /> </center> 
            
<?php
    ?> 
        <h4> Ingrédients </h4>
        <?php
        if(!$detail) {
        ?>
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
    
        }
        else {
        ?>
            <span> <?php echo $cocktail["ingredients"]; ?> </span> <?php /* affichage mieux à faire */ ?>
        <h4> Préparation </h4>
            <span> <?php echo $cocktail["preparation"]; ?> </span> 
        <?php
}
                if(isset($cocktail["score"])) {
                    echo "score de ".number_format($cocktail["score"], 2)." %"; //TODO affichage à paufiner
                }

            ?>
        </div>
<?php
    }
}
}


/*
    Vérifie si le login passé en paramètre a une syntaxe correcte
*/
function verification_login($login){
    if (isset($_SESSION['utilisateur'])){
        foreach($_SESSION['utilisateur'] as $util)
        {
            if ($util == $login) return "login déjà utilisé, veuillez en saisir un autre";
        }
    }
    if (!(preg_match('/^[a-zA-Z0-9]+$/', $login))) return "erreur de syntaxe : le login doit uniquement être constitué de lettres non accentuées minusclues ou majuscules et/ou de chiffres";
    else return "ok";
}

/*
    Vérifie si le nom ou le prénom passé en paramètre a une syntaxe correcte
*/
function verification_nom_prenom($nom){
    if (!(preg_match("/^([\p{L}a-zA-Z]+\s*|[\p{L}a-zA-Z]*|([\p{L}a-zA-Z]+-[\p{L}a-zA-Z]+)|([\p{L}a-zA-Z]+'[\p{L}a-zA-Z]+))+$/u", $nom))) return "erreur de syntaxe : le nom/prénom doit être constitué de lettres majuscules ou minuscules, d'espaces et/ou de tirets ou apostrophes encadrés de deux lettres";
    else return "ok";
}




?>
