<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$crypt = $visiteur->getCrypt();

$visiteur->InitialMod(); //on initialise à zero les mods(modif ou ajouter)
$start = new startIndex($visiteur, 51); //5 = ADMINISTRATION
if (!in_array('FF', $visiteur->getHexaAuthVisiteur())) {//si ce n'est pas un SU directe erreur
    Route::routage(8001); //redirection erreur
}

$menu = $start->getLienMenu();
$html = new Html("Listes des membres");
$html->banniere('Menu Application SAV');
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>

</section>
<?php
$html->footer();
?>


