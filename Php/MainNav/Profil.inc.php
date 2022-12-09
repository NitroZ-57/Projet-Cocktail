<main>

<?php include("Php\Traitement\TraitementProfil.php"); ?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_mdp"> 

        Changer le Mot de Passe : <input type="password" name="nouveau_mot_de_passe" /> </br>

    <input type="submit" name="Changement_mdp" value="Valider"> </br>

</form>

</br>

<?php echo ("Votre nom actuel : ".$_SESSION["utilisateur"]['nom']); ?>

</br>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_nom"> 

        Changer le Nom : <input type="text" name="nouveau_nom" /> </br>

    <input type="submit" name="Changement_nom" value="Valider">

</form>

</br>

<?php echo ("Votre prénom actuel : ".$_SESSION["utilisateur"]['prenom']); ?>

</br>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_prenom"> 

        Changer le Prénom : <input type="text" name="nouveau_prenom" /> </br>

    <input type="submit" name="Changement_prenom" value="Valider"> </br>

</form>

</br>

<?php echo ("Votre sexe actuel : ".$_SESSION["utilisateur"]['sexe']); ?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_sexe"> 

        Changer le genre : <input type="radio" id="Homme" name="nouveau_sexe" value="Homme">
                        <label for="Homme">Homme</label>
                        <input type="radio" id="Femme" name="nouveau_sexe" value="Femme">
                        <label for="Femme">Femme</label> </br>

    <input type="submit" name="Changement_sexe" value="Valider"> </br>

</form>

</br>

<?php echo ("Votre date de naissance actuelle : ".$_SESSION["utilisateur"]['naissance']); ?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Changement_naissance"> 

        Changer la date de naissance : <input type="date" name="nouvelle_naissance" id="nouvelle_naissance"/> </br>

    <input type="submit" name="Changement_naissance" value="Valider"> </br>

</form>

</main>

<script type="text/javascript">

//obligé de le mettre ici pour forcer la date maximum possible à 18ans avant la date du jour

var max = new Date();
var dd = max.getDate();
var mm = max.getMonth()+1; //Janvier est égal à 0 par defaut, il faut donc ajouter 1 au mois
var yyyy = max.getFullYear()-18;
 if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

max = yyyy+'-'+mm+'-'+dd;
document.getElementById("nouvelle_naissance").setAttribute("max", max);

var sexe = '<?php echo $_SESSION['utilisateur']['sexe'] ?>';

if (sexe === "Homme")
    document.getElementById("Homme").setAttribute("checked", "checked");

if (sexe === "Femme")
    document.getElementById("Femme").setAttribute("checked", "checked");

var naissance = '<?php echo $_SESSION['utilisateur']['naissance'] ?>';

document.getElementById("nouvelle_naissance").setAttribute("value", naissance);

</script>