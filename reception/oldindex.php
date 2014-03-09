<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
if(empty($_POST))//si on a pas posté on est en mode ajouter
{
    
}
//var_dump($visiteur);
$start = new startIndex($visiteur, 10); //context 10 ajouter un client
$menu = $start->getLienMenu();
$html = new Html("RECEPTION :");
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/affaire.css">'); //ajouter le css admin
$html->banniere('Menu Application SAV');
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>

    <h1>ajouter fiche affaire</h1>
    <?php
    $form_affaire = new FormAffaire('../reception/verif_saisie_affaire.php','coordonée du membre');
    $form_affaire->formInputAppareil();
    $form_affaire->endForm('nouvelle affaire');
    /*
     * PROJET STEPHANE NGOV
     */
    ?>

</article>





