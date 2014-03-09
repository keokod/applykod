<?php

require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 0); //context 10 ajouter un client

//*************************************** PREPARTATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('fiche piece');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/stock.css">'); //ajouter le css admin
$html->banniere('PIECE :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>
<?php
//*********FORMULAIRE AJOUTER PIECE***************
$visiteur->getCollectErr();
if (isset($_POST['modifier']) || $visiteur->getAjouterOrModifier() == 'M') {
    $submit = "modifier";
    $visiteur->setModeModifier();
} else {
    $submit = "ajouter";
    $visiteur->setModeAjouter();
    $visiteur->clearInputForm();
}

$add_piece = new FormPiece('verif_saisie_piece.php', 'ajouter piece en stock');
if ($visiteur->getInputForm() != NULL) {
    $add_piece->hydrateFormPiece($visiteur->getInputForm());
}
$add_piece->formInputPiece();
$add_piece->endForm($submit . ' piece');
?>
</article>
</section>
<aside>
    <?php
    $html->footer();
    ?>

    