<?php

require_once'../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
if (!empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['crypt'])) {//les champs doivent être remplis
    $inconnu = new Membre();
    //si correspondance entre email et mdp, on remplira les attributs du membres
    $inconnu->isMembreExist($_POST['email'], $_POST['mdp'], $_POST['crypt']); //récupère les data membre ET AUSSI LES AUTORISATIONS!
    $id_inconnu = $inconnu->getIdMembre();

    //$id_inconnu = $inconnu->getIdMembre(); //rechecher le membre qui possède le couple email/
    if ($id_inconnu === NULL) {
        Route::routage(0);
        $visiteur->moinsTentative(); //EN CAS D'ECHEC ON DECOMPTE -1 TENTATIVE
        $reste_tentative = $visiteur->getResteTentative() +1;
        $visiteur->setFlashInfo('invalide, reste '.($reste_tentative)."tentative(s)");
    } else {//SI LE COUPLE MOT DE PASSE ET LOGIN OK ON RECHERCHE LE VISITEUR
        $visiteur->clearFlashInfo();
        $visiteur->setVisiteur($id_inconnu, $inconnu->getNom(), $inconnu->getHexaAuth(), $inconnu->getTypeUser());
        if ($inconnu->getTypeUser() == 'client') {
            Route::routage(2); // aller à la page service client
        }
        if ($inconnu->getTypeUser() == 'reception') {
            Route::routage(1005); // aller à la page rechercher recherche membre
        }
        if ($inconnu->getTypeUser() == 'magasin') {
            Route::routage(5000); // ajouter une pièce 
        }
        if ($inconnu->getTypeUser() == 'technique') {
            Route::routage(6000); // aller à la page application menu principal  
        }
        if ($inconnu->getTypeUser() == 'SU') {
            Route::routage(1); // aller à la page application menu principal 
        }
        if (in_array('XX', $inconnu->getHexaAuth())) { //les autorisations son XX forcer la modification du compte SU
            Route::routage(9999);
        }
    }
} else {//avant d'arriver à cette route il y a normalement le javascript qui surveille la saisie des champs
   $visiteur->setFlashInfo('connexion échoué');
   Route::routage(8002); //si au dela de 4 essais erreurs
}
//PROJET STEPHANE NGOV V1.10
?>