<?php
require_once '../lib/Ini.php'; //CLOTURER INTERVENTION
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application
$menu = $start->getLienMenu();

//*************************************** PREPARTATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/tech.css">'); //ajouter le css admin
$html->banniere('technique :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>
    <?php
    if (isset($_GET['id_facture'])) {
        $id_facture = $_GET['id_facture'];
        $voir_facture = new Facture();
        $id_affaire = $voir_facture->recupIdAffaire($id_facture);
        include'../facture/detail_facture.php';
        $facture = $voir_facture->voirFacture($id_affaire);
        ?>

        <?php
    }
    ?>
</article>
</section>
<aside><!-- balise aside fermante dans le footer -->

    date facture : <?php echo $facture['date'] ?><br/>
    date numero affaire : <?php echo $facture['id_affaire'] ?><br/>
    total facture : <?php echo $facture['correction_total_ht'] ?><br/>
    remarque : <?php echo $facture['remarque'] ?><br/>
    <?php
    $html->footer();
    ?>

