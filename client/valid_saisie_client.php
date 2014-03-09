<?php

require_once '../lib/Ini.php';

if (!empty($_POST)) {//on vérifier qu'on a poster 
    $visiteur = $_SESSION['visiteur']; //recupération de la sesion visiteur
    //A = ajouter, M= modifier, permet aussi le comportement de saisie mdp
    $ajouter_or_modifier = $visiteur->getAjouterOrModifier();
    $verif_membre = new VerifMembre($_POST);

    $verif_membre->verifSimpleAnnuaire(); //vérifie les champs remplis
    $nb_erreur = count($verif_membre->getCollectErr());
    if ($nb_erreur == 0) { //si pas d'erreur on peut continuer
        if ($visiteur->getAjouterOrModifier() == "A") {
           $inscrire_membre = new Inscription();
          if($visiteur->getTypeUserVisiteur() =='reception') // si on est connecté sous un receptionniste on enregistre obligatoirement un client
            {
                $hexa_auth_membre = NULL;//si on est connecté sous un receptionniste le client n'a pas d'
            }
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
        Route::routage(1002); //champ mal remlit on recommence 
    }
} else {//si pas de poste on dirige vers une erreur
        Route::routage(8000);
}

