<?php
/*
require_once '../lib/Ini.php'; //RECHERCHER
extract($_POST);
$visiteur = $_SESSION['visiteur'];
if (isset($mot_cle) && isset($crypt) && isset($route) && isset($champ)) {
    //vérifie que c'est un sting
    $verif = new Verif();
    $verif->validNom($mot_cle);
    $nb_erreur = count($verif->getCollectErr());
    if ($nb_erreur != 0) {//si erreur on renvoie le formulaire
        $visiteur->setFlashInfo("introuvable");
        $visiteur->refreshVisiteur();
        Route::routage($route);
    }
    $recherche = new MoteurRecherche($table, $champ, $mot_cle);
    $recherche->findSimpleChamp();
    Route::routage($route);
    
} else {
    Route::routage(8001);
}
 * 
 */
?>
<h1>recherche</h1>
