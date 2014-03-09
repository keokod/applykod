<?php
require_once '../lib/Ini.php';
require_once '../lib/Recherche.php';

if(!empty($_POST['mot_cle'])) //si il est pas vide on recherche la saisie 
{
    $recherche = new Recherche($_POST);
    if($_POST['condition'] == 1)
    {
        $sujet = " AND type_user = 'client' ";
    }
    $recherche->findConditionTypeMembre($sujet);
}else{
   $_SESSION['visiteur']->setErreur(array('le champs est vide !')); // informer que le champs est vide
   $_SESSION['visiteur']->refreshVisiteur();
     Route::routage(1005);
}
?>
<h1>vérifier le saisie du membre</h1>
