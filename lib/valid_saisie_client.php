<?php

require_once '../lib/Ini.php';

if (!empty($_POST)) {//on vérifier qu'on a poster 
    $visiteur = $_SESSION['visiteur']; //recupération de la sesion visiteur
    //A = ajouter, M= modifier, permet aussi le comportement de saisie mdp
    $ajouter_or_modifier = $visiteur->getAjouterOrModifier();
    $verif_membre = new VerifMembre($_POST);
    
    //*****************POUR UN CLIENT PAS D AUTORISATION********************/
    //$select_check_membre = new SelectCheckMembre($_POST); //on récupère les autorisations coché
    //$hexa_auth_membre = $select_check_membre->getCheckAuth(); //on récupère les autorisations
    //
    //
    //on vérifie que les mots de passe sont remplis (à moitier) ou pas
    //dans n'importe quel situation si l'un des champs sont remplit on vérifie le mot de passe
    //*****************POUR UN CLIENT DE VERIFIER LES MOTS DE PASSE********************/
    //if (!empty($_POST['mdp']) || !empty($_POST['confirm_mdp'])) {
    //    $force_verif_mdp = TRUE;//dans n'importe quel situation si l'un des champs sont remplit on vérifie le mot de passe
    //} else {
    //    $force_verif_mdp = FALSE;//sinon pour il se peut qu'on n'a pas besoin de modifier le mdp
    //}

    $verif_membre->verifSimpleAnnuaire(); //vérifie les champs remplis
    /*
    if ($ajouter_or_modifier == "A" || $force_verif_mdp == TRUE) {
        var_dump($visiteur->getTypeVisiteur());
        //$verif_membre->verifMdp();
    }//dans le cas d'une modification si les champs mdp sont vide, on ne les modifies pas
     * 
     */


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

