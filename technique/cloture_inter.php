<?php
require_once '../lib/Ini.php'; //CLOTURER INTERVENTION
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application

//*************************************** PREPARTATION DE LA PAGE HTML + MENU  ***  PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/facture.css">'); //ajouter le css admin
$html->banniere('technique :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION

?>
<article id="facture">  
    <?php
    $visiteur-> getErreur();
    echo "<br/>";
    $id_affaire = $visiteur->getMemNextAction(); //on récupérer l'id affaire

    echo "<h2>cloturer affaire numéro :" . $id_affaire . "</h2>";

    include '../facture/detail_facture.php';

    echo "prix total pièce HT :" . $prix_piece . "euros <br/>";
    echo "prix intervention total HT:" . $prix_inter = ($prix_inter * 80) . "euros <br/>";
    ?>
    <h1>prix HT total reelle <?php echo $total_facture = $prix_piece + $prix_inter ?> euros</h1>
    
    <?php
    $form_facture = new FormFacture('../facture/verif_facture.php', 'Formulaire facture');
    $form_facture->formInputFacture($total_facture);
    $form_facture->endForm('Creer facture');
    ?>
</article>

</section>

    <?php
    $html->footer();
    
    /*PROJET STEPHANE NGOV V1.38**/
    ?>