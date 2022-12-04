<main>
    
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="Inscription"> 

<fieldset>
    <legend>Informations Obligatoires</legend>

        Login : <input type="text" name="login" required="required" /> </br>

        Mot de Passe : <input type="password" name="mot_de_passe" required="required" /> </br>

</fieldset>
</br>
<fieldset>
    <legend>Informations Complémentaires</legend>

        Nom : <input type="text" name="nom" /> </br>

        Prénom : <input type="text" name="prenom" /> </br>

        Sexe : <input type="radio" id="Homme" name="sexe" value="Homme">
                <label for="Homme">Homme</label>
                <input type="radio" id="Femme" name="sexe" value="Femme">
                <label for="Femme">Femme</label> </br>

        Date de naissance : <input type="date" name="naissance" id="naissance"/> </br>

</fieldset>
</br>
    <input type="submit" name="inscription" value="S'inscrire">

</form>

</main>

</br>


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
document.getElementById("naissance").setAttribute("max", max);

</script>