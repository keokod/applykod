<?php
require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 0); //context 10 ajouter un client
//reinitialiser les modes ajouter ou modifier

$visiteur->InitialMod();
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
$html->banniere('PIECE :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>
    <?php
//détail de la fiche piece
    $piece = new Piece();
    $data = $piece->recupPiece($id_piece);
//on récupère le resultat pour le mode edition
    $visiteur->setInputForm($data);
    ?>

    <form method="POST" action="ajouter_piece.php">
        <input type="hidden" name="modifier">
        <input type="submit" value="editer piece">
    </form>
    <table>
        <tr>
            <td>numero piece</td><td><?php echo $data['id'] ?></td>
        </tr>
        <tr>
            <td>nom de la piece</td><td><?php echo $data['nom_piece'] ?></td>
        </tr>
        <tr>
            <td>référence</td><td><?php echo $data['reference'] ?></td>
        </tr>
        <tr>
            <td>quantite disponible</td><td><?php echo $data['quantite'] ?></td>
        </tr>
        <tr>
            <td>fournisseur</td><td><?php echo $data['fournisseur'] ?></td>
        </tr>
        <tr>
            <td>prixHT</td><td><?php echo $data['prixHT'] ?></td>
        </tr>
        <tr>
            <td>localisation</td><td><?php echo $data['localisation'] ?></td>
        </tr>
        <tr>
            <td>caracteristique</td><td><?php echo $data['caracteristique'] ?></td>
        </tr>
        <tr>
            <td>dimension</td><td><?php echo $data['dimension'] ?></td>
        </tr>
    </table>

</article>
</section>
<aside>
    <?php
    $html->footer();
    ?>


