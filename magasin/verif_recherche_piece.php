<?php

require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$visiteur->setNextRoute(5001);

if (!empty($_POST)) {
    $recherche = new Recherche($_POST);
   $resultat = $recherche->findSimpleChamp();
} else {
    Route::routage(5001);
}
?>
