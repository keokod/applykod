<?php

require_once '../lib/Ini.php'; //INDEX MENU TECHNICIEN

if (!empty($_POST) && isset($_POST['crypt'])) {
    //VERIFIACTION DES SAISIES FORMULAIRE INTERVENTION
    $verif_inter = new VerifIntervention($_POST);
    $erreur = $verif_inter->verifInter();
    
    if ($erreur === FALSE) {
        $visiteur = $_SESSION['visiteur'];
        $erreur = $verif_inter->getCollectErr();
        $visiteur->setErreur($erreur); //si erreur on recommence
        $visiteur->setInputForm($_POST);
        Route::routage(6001);
    } else {//si par erreur on enregistre ou modifie l'intervention
        $visiteur = $_SESSION['visiteur'];
        $inter = new Intervention();
        if ($visiteur->getAjouterOrModifier() == 'M') {
            $inter->modifInter($_POST); //modifier l'intervention
        } else {
            $inter->addInter($_POST);
        }
    }
} else {
    Route::routage(8000);
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
