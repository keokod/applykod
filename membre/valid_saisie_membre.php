<?php

require_once '../lib/Ini.php';

if (!empty($_POST)) {//on vérifier qu'on a poster 
    $visiteur = $_SESSION['visiteur']; //recupération de la sesion visiteur

    //A = ajouter, M= modifier, selon le contexte
    $ajouter_or_modifier = $visiteur->getAjouterOrModifier();
    $verif_membre = new VerifMembre($_POST);
    $select_check_membre = new SelectCheckMembre($_POST); //on récupère les autorisations coché
    $hexa_auth_membre = $select_check_membre->getCheckAuth(); //on récupère les autorisations
 
    $verif_membre->verifSimpleAnnuaire(); //vérifie les champs remplis

    $nb_erreur = count($verif_membre->getCollectErr());
    if ($nb_erreur == 0) { //si pas d'erreur on peut continuer
        if ($visiteur->getAjouterOrModifier() == "A") {
            $inscrire_membre = new Inscription();
            $inscrire_membre->inscrireMembre($_POST, $hexa_auth_membre);
        } else {
            $modifier_membre = new Inscription();
            $modifier_membre->modifMembre($_POST, $hexa_auth_membre, $force_verif_mdp);
        }
    } else {
        //si on a une erreur on récupère le poste et le réidrate
        $visiteur->setInputForm($_POST); //on récupère les saisies
        $visiteur->setHexaAutConcerne($hexa_auth_membre);
        $visiteur->setErreur($verif_membre->getCollectErr());
        Route::routage(7000); //champ mal remlit on recommence 
    }
} else {//si pas de poste on dirige vers une erreur
        Route::routage(8000);
}