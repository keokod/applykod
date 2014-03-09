<?php
require_once '../lib/Ini.php';//appelle du fichier qui appelle le chargement des classe
// enregistre le membre, utilisation de la classe 
echo "membre enrgistrer";//inscription SU = index.php->inscrireSU.php->enregistre_membre.php
$bdd = Bdd::getIntance();
$inscription_su = new Inscription($bdd->getIntance());


    echo  $_POST['civilite'];


$inscription_su->inscrireMembre(
        $_POST['email'],
        $_POST['pass'],
        $_POST['civilite'],
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['adresse'],
        $_POST['telephone'],
        $_POST['role']);


?>
