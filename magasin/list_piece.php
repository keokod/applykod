<?php
require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 0); //context 10 ajouter un client
//reinitialiser les modes ajouter ou modifier

$visiteur->InitialMod() ;
//récupération du numéro de la fiche piece

if (isset($_GET['id_piece'])) {
    $id_piece = $_GET['id_piece'];
    $visiteur->setMemNextAction($id_piece);
} else {
    $id_piece = $visiteur->getMemNextAction();
}

//*************************************** PREPARTATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('STOCK :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/stock.css">'); //ajouter le css admin
$html->banniere('magasinier :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$menu_courrant  = $start->filtreMenu($menu,"magasin");//filtre seulement menu de la page courrant
$html->navMenu($menu_courrant, 'menu_action'); //MENU ACTION LATTERAL GAUCHE
?>
<article>
<?php
$piece = new Piece();
$last_piece =$piece->listPiece();
?>
<h1>dernière pièce ajouter</h1>
<table>
    <th>dispo</th> <th>nom piece</th><th>reference</th><th>destoker - 1</th><th>stocker +1</th><th>detail</th>
<?php
foreach ($last_piece as $L)
{
    ?>
    <tr>
        <td><?php echo $L->quantite?></td> 
        <td><?php echo $L->nom_piece?></td>
        <td><?php echo $L->reference?></td>
        <td><a href="plus_moin_piece?id_piece=<?php echo $L->id ?>&quantite=1&moins">-1</a> </td>
        <td><a href="plus_moin_piece?id_piece=<?php echo $L->id ?>&quantite=1&plus">+1</a> </td>
        <td><a href="fiche_piece.php?id_piece=<?php echo $L->id ?>"> detail </a> </td>
    </tr>
<?php
}
?>
</table>
</article>
</section>
<aside>
    <?php
    $html->footer();
    ?>