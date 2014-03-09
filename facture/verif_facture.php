<?php

require_once '../lib/Ini.php'; //CLOTURER INTERVENTION

if (isset($_POST['total']) && isset($_POST['remarque'])) {
    $verif = new Verif($_POST);
    if ($verif != FALSE) {
        $verif->validIsFloat($_POST['total']);
      //  $verif->validAlphaNum($_POST['remarque']);
        if (count($verif->getCollectErr()) > 0) {
            $visiteur = $_SESSION['visiteur'];
            $visiteur->setErreur($verif->getCollectErr());//récupération des erreurs
          Route::routage(6003); //revenir la page cloturer l'affaire
        } else {
            $facture = new Facture();
            $facture->creeFacture($_POST);
            Route::routage(2000);//creation facture
        }
    }
} else {
    echo "erreur redirection 8000 ";
}


/*PROJET STEPHANE NGOV V1.38**/
?>