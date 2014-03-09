<?php

require_once '../lib/Ini.php'; //VERIF SAISI AFFAIRE
$visiteur = $_SESSION['visiteur'];
//on vérifi si la saisie
//$enregistre_affaire = new Affaire($crypt);
//$verif_affaire = new VerifPiece($_POST);
//$nb_erreur = $verif_affaire->verifPiece();
$nb_erreur = TRUE;
if ($nb_erreur === FALSE) {//si erreur on recommence le formulaire 
    echo "<h1>erreur saisie</h1>";
    // $visiteur->setErreur($verif_affaire->getCollectErr());
    $visiteur->setInputForm($_POST);
    //  Route::routage(5000);
} else {//si par erreur on charge la pièce
    $add_piece = new Piece();
    $add_sub = $visiteur->getAjouterOrModifier();
    if ($add_sub == 'A') {
        $add_piece->addPiece($_POST);
    } else {
        $add_piece->modifPiece($_POST);
    }
  Route::routage(5002);
}
?>
