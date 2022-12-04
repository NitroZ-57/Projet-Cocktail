<main>
    
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_mdp"> 

        Changer le Mot de Passe : <input type="password" name="mot de passe" /> </br>

    <input type="submit" name="page" value="Valider">

</form>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_nom"> 

        Changer le Nom : <input type="text" name="nom" /> </br>

    <input type="submit" name="page" value="Valider">

</form>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_prenom"> 

        Changer le Prénom : <input type="text" name="prenom" /> </br>

    <input type="submit" name="page" value="Valider">

</form>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_sexe"> 

        Changer le genre : <input type="radio" id="Homme" name="sexe" value="Homme">
                        <label for="Homme">Homme</label>
                        <input type="radio" id="Femme" name="sexe" value="Femme">
                        <label for="Femme">Femme</label> </br>

    <input type="submit" name="page" value="Valider">

</form>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_naissance"> 

        Changer la date de naissance : <input type="date" name="naissance"/> </br>

    <input type="submit" name="page" value="Valider">

</form>

</main>