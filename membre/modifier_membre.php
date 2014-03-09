<?php

require_once '../lib/Ini.php';
extract($_POST);

$verif = new Verif();
$verif->validEmail($email);
$verif->strMinMax($mdp, 4, 8, 'mot de passe'); //4 = minimum caractère 8 = max caractere
$verif->validMdp($mdp, $confirm_mdp);
$verif->validSelect($civilite, 0, 3, 'civilite'); //civilité doit être supérieur à et inférieur ou égal à 3
$verif->strMinMax($nom, 2, 50, 'nom de famille'); //le caractère de nom doit être compris entre 2 et 50 caractere
$verif->validNom($nom);
$verif->strMinMax($prenom, 2, 50, 'prénom');
$verif->validPrenom($prenom);
$verif->strMinMax($adresse, 3, 300, 'adresse');
$verif->validAdresse($adresse);
$verif->validTelephone($telephone);

if ($verif->getCollectErr() == NULL) {//si pas d'erreur appelle la class inscription
    echo "on hydrate à nouveau le membre";
    $membre = new Membre();
    $membre->hydratModifMembre($_POST);
    $modif_inscrit = new Inscription();
    $modif_inscrit->modifMembre($crypt,$membre); //pour la sécurité on envoie le post du jeton
    //si la requête ok, on affiche la page membre, sinon on recommence
} else {
    $visiteur = $_SESSION['visiteur'];
    //print_r($verif->getCollectErr());
    $visiteur->setErreur($verif->getCollectErr());
    $visiteur->refreshVisiteur();
   // Route::routage(9999);//oublie mdp.php
}
