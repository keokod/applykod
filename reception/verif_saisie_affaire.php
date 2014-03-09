<?php

require_once '../lib/Ini.php'; //VERIF SAISI AFFAIRE
$visiteur = $_SESSION['visiteur'];
//on vérifi si la saisie
//$enregistre_affaire = new Affaire($crypt);
$verif_affaire = new VerifAffaire($_POST);
$is_affaire_ok = $verif_affaire->verifFicheAffaire();
$affaire = new Affaire($_POST['crypt']);
if ($is_affaire_ok === TRUE) {
    if ($visiteur->getAjouterOrModifier() == 'A') {
       $affaire->ajouterAffaire($_POST);
    } else {
        $affaire->modifAffaire($_POST);
    }
}
?>
