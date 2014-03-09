<?php
require_once '../lib/Ini.php'; //AJOUTER AFFAIRE
$visiteur = $_SESSION['visiteur'];
$titre = "Modifier appareil";
$start = new startIndex($visiteur, 1); //1 = menu application
$menu = $start->getLienMenu();

//*************************************** PREPARTATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('APPAREIL :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/techn.css">'); //ajouter le css admin
$html->banniere('affaire :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>
    <?php
    if (isset($_GET['id_appareil'])) {
        $appareil = new Appareil();
        $data = $appareil->recupAppareil($_GET['id_appareil']);
    }
    echo '<h2>Modifier appareil</h2>';
    include '../technique/ajouter_appareil.php';
    ?>



</article>
</section>
<aside>
<?php
$visiteur->getErreur();
$html->footer();
?>

