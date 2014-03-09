<?php
require_once '../lib/Ini.php';//MENU APPLICATION PRINCIPAL
$start = new startIndex($_SESSION['visiteur'],1);//1 = menu application
$html = new Html("Administration SAV");
$html->banniere('Menu Application SAV');
$html->navAccueil($start->getLienCategorie());
$recherche_client = new FormClient('rechercher_client.php', 'rechercher un client');
$html->footer();
?>
