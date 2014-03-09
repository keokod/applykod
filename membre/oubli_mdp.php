<?php

require_once '../lib/Ini.php';
if ($_SESSION['visiteur'] == NULL) {
    Route::routage(8001); //si la session existe pas erreur 
} else {//on récupère les autorisations
    $visiteur = $_SESSION['visiteur'];
    $hexa_auth = $visiteur->getHexaAuthVisiteur();
    if (!in_array('FF', $hexa_auth)) {//si XX forcer la modif profil SU
        echo "profil normal, vérifier son autorisation";
    } else {//si hexa_auth = XX forcer la modif du compte SU
        //à la prochain connexion plus d'impostion de modification de SU
        $force_auth = new Autorise();
        $id_su = $visiteur->getIdVisiteur();
        //$force_auth->ajouterAuth($id_su, array('FF')); //on demande de modifier XX en FF;
        $visiteur->setHexaAuthVisiteur(array('FF')); //raffraîchir l'autorisation pour la suite
        $form_su = new FormAnnuaire(RACINE . 'membre/valid_saisie_su.php', 'modifier le compte SU');
        //on recherch le id_clientd ans la session
        //hydrate le membre SU a modifier
        $form_su->hydrateModifier($id_su);
        $form_su->formSimpleFormMembre();
        $form_su->formEmailValidMdp();
        $form_su->endForm('Modifier le compte SU');
        $visiteur->getErreur();
        
    }
    //affiche les erreurs de retour du formulaire de modification
    if ($visiteur->getCollectErr() != NULL) {//si on a des derreurs à afficher;
        $visiteur->getCollectErr(); //afficher les erreurs
    }
}
?>
