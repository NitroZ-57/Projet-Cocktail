<?php




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

function nom_du_cocktail($cocktail) {
    if( preg_match('#(^[^\(]*)#i', $cocktail, $regs) ) {
        return $regs[1];
    }
    else 
        return false;
}

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


?>