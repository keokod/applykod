<?php

require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
$id_affaire_tech = $visiteur->getMemNextAction() ;
//  header('Location: ../technique/fiche_intervention.php?id_affaire_tech=' . $id_affaire . '&crypt=' . $visiteur->getCrypt() . ''); //rechercher un client -->
$piece = new Piece();

$erreur = FALSE;
$message_err = array();
$_SESSION['erreur'] = array();

foreach ($_POST as $key => $qte) {
    $dispo = $piece->dispoPiece($key, $qte);
    if ($dispo < 1) {
        $erreur = 1;
        $message_err[] = "la pièce numero".$key." est épuisé, merci de corriger sa quantité"; 
    }
}

if ($erreur == FALSE) {// si false ok on redirige vers la page des résumer affaire
    foreach ($_POST as $key => $qte) {
        $piece->destock($id_affaire_tech , $key, $qte);
    }
    Route::routage(6004); //vers la page des résumer affaire;
} else {
    $visiteur->setInputForm($_POST);
    $visiteur->setErreur($message_err);
    Route::routage(6005);//retour voir panier rectifier les quantités car indispo
}

//  var_dump($visiteur);
?>
