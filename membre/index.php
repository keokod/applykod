<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, '50'); //ajouter client


if (!in_array('FF', $visiteur->getHexaAuthVisiteur())) {//si ce n'est pas un SU directe erreur
    Route::routage(8001); //redirection erreur
}


$menu = $start->getLienMenu();
//pérparation des cheeksbox
$html = new Html("Employé");
$html->headPlus('<link rel=stylesheet type="text/css" href="../css/admin.css">'); //ajouter le css admin
$html->banniere('Employé');
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu');
?>
