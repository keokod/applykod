<?php
require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application
//*************************************** PREPARTATION DE LA PAGE HTML + MENU PROJET STEPHANE NGOV****************************************
$html = new Html('PIECE');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/stock.css">'); //ajouter le css admin
$html->banniere('recherche piece');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION

$visiteur = $_SESSION['visiteur'];
$panier = $_SESSION['panier'];
$panier = array_unique($panier); //EVITER LES DOUBLONS DE PIECE COMMANDER PLUSIEUR FOIS
$liste = implode(',', $panier);
$liste_panier = new Piece();
$panier_choix = $liste_panier->listePiecePanier($liste);
$id_affaire = $visiteur->getMemNextAction();
$erreur = array();

$visiteur->getErreur();
?>
<article>
    
    
  
    <table id="destock">
        <tr>
            <th>numero</th>
            <th>nom piece</th>
                  <th>référence</th>      
            <th>quantite</th>
            <th>prix HT</th>  
            <th>localisation</th> 
            <th>dimension</th> 
            <th>quantite destocker</th>
        </tr>
        <form action="valid_panier.php" method="POST">
            <?php
           $_SESSION['panier_choix'] = $panier_choix ; //le nom des articles selectionner
            
            
            foreach ($panier_choix as $R) {
                ?>
                <tr>
                    <td><?php echo $R->id ?></td>
                    <td><?php echo $R->nom_piece ?></td>
                    <td><?php echo $R->reference ?></td>
                    <td><?php echo $R->quantite ?></td>
                    <td><?php echo $R->prixHT ?></td>
                    <td><?php echo $R->localisation ?></td>
                    <td><?php echo $R->dimension ?></td> 
                    <?php
                    if ($R->quantite > 0) {
                        ?>
                        <td>
                            <input type="text" name="<?php echo $R->id ?>" value="<?php
                            if (isset($_POST['qte'])) {
                                echo $_POST['qte'];
                            } else {
                                echo  "1";
                            }
                            ?>">
                        </td>
                            <?php
                        } else {
                            echo "<td>indisponible</td>";
                        }
                        ?>
                </tr>
                <?php }
            ?>
            <input type="submit" value="destocker">
        </form>
        <br/>
    </table>
    <a href="#null" onclick="javascript:history.back()">revenir à la recherche d'une pièce</a><br/>
    <?php
    if (isset($_SESSION['panier'])) {

        echo "<h4>" . count(array_unique($_SESSION['panier'])) . " pièce(s) on(t) été sélectionnée(s)</h4>";
    } else {
        $_SESSION['panier'] = array(); //creation de la session panier de piece
    }
    ?>
</article>
</section>
<aside><!-- balise aside fermante dans le footer -->
    <?php
    $html->footer();
    ?>