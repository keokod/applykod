<?php
require_once '../lib/Ini.php'; //INDEX MENU TECHNICIEN
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1);
$menu = $start->getLienMenu();

//*************************************** PREPARATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/tech.css">'); //ajouter le css admin
$html->banniere('technique :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>
    <?php
        //on récupère l'affaire depuis le get
        $recup_affaire = new Affaire($_GET['crypt']);
        $id_affaire = $_GET['id_affaire_tech'];
        $affaire_tech = $recup_affaire->recupficheAffaire($_GET['id_affaire_tech']);
        $visiteur->setResultFind($affaire_tech);

    $inter = new Intervention();
    $intervention = $inter->listeInter($id_affaire);
    ?>

    <!-- PARTIE PIECE , LIEN CREATION DEVIS , APPAREIL REPARER -->
    <h1>intervention effectué</h1>
    <table>
        <tr>
            <th>date intervention</th><th>tache</th><th>id_tech</th><th>duree</th><th>etat</th>
        </tr>
        <?php
        $duree_total = NULL;
        foreach ($intervention as $I) {
            ?>
            <tr>
                <td><?php DateFr::afficheDate($I->date_inter); ?></td>
                <td><?php echo $I->tache; ?></td>
                <td><?php echo $I->id_tech; ?></td>
                <td><?php echo $I->duree; ?></td>       
                <td><?php
        switch ($I->etat) {
            case 1:
                echo "estimation";
                break;
            case 2:
                echo "en cour";
                break;
            case 3:
                echo "terminer";
                $duree_total += $I->duree; //on additionne le temps si terminer
                break;
            case 4:
                echo "annuler";
                break;
        }
            ?></td>
                <td><a href="ajouter_intervention.php?id=<?php echo $I->id . "&crypt=" . $visiteur->getCrypt() ?>">modifier</a></td>
            </tr>
            <?php
        }
        echo "<h1>durée total des interventions  terminé" . $duree_total . " H</h1>";
        $visiteur->setMemNextAction($id_affaire); //on récupére l'affaire en cours 
        ?>
    </table>
    
    <h1><a href="../technique/ajouter_intervention.php">Ajouter une autre intervention</a></h1>
    <h1><a href="cloture_inter.php">réparation terminé</a></h1>

</article>

</section>

<aside><!-- balise aside fermante dans le footer -->
    <?php
//**********************AFFICHAGE DES INFORMATIONS SUR L APPAREIL ET LE CLIENT*********************************
    $data_aff = $visiteur->getResultFind(); //récupération des donnnées affaire depuis la page fiche reception affaire

    echo "<h2>numéro affaire " . $id_affaire . "  </h2>";
    ?>
    <h3>intervention du technicien  :  <?php echo $visiteur->getNomVisiteur() ?></h3>
    <h3>appareil <?php echo $data_aff->reference ?> </h3>
    numero de serie <?php echo $data_aff->numero_serie ?><br/>
    localisation <?php echo $data_aff->localisation ?><br/>
    client: <?php echo $data_aff->nom ?><br/>
    remarque  <?php echo $data_aff->remarque ?><br/>

    <h3>piece consommé</h3>
    <a href="../magasin/rechercher_piece.php?id=<?php echo "&crypt=" . $visiteur->getCrypt() ?>">destocker piece</a>
    <?php
    $piece_util = new Piece();
    $list_piece = $piece_util->pieceAffaire($id_affaire);
    ?><table>
        <th>nom piece</th><th>reference</th><th>prix HT</th><th>nombre utilisé</th>
        <?php
        $piece_ht_total = NULL;
        foreach ($list_piece as $L) {
            ?>
            <tr>
                <td><?php echo $L->nom_piece ?></td>
                <td><?php echo $L->reference ?></td>
                <td><?php echo $L->prixHT ?></td>     
                <td><?php echo $L->nb ?></td>

            </tr>
            <?php
            $piece_ht_total +=$L->prixHT;
        }
        ?></table>
        <?php
        echo "total prix pièce =" . $piece_ht_total . " total heure:" . $duree_total . "<br/>";
        echo " = " . $piece_ht_total + ($duree_total * 80) . "euros (80/heures)";

        $html->footer();
        ?>