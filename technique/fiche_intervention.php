<?php
require_once '../lib/Ini.php'; //INDEX MENU TECHNICIEN
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1);
$menu = $start->getLienMenu();

//nettoyage des sessions panier

$_SESSION['panier_choix'] = 0;
if(isset($_SESSION['panier']))
{
    unset($_SESSION['panier']); // on détruit la session panier d'article
}

//*************************************** PREPARATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/tech.css">'); //ajouter le css admin
$html->banniere('technique :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
echo '<article>
<a href="#null" onclick="javascript:history.back();">Précédent</a>';

//********************GET = MODIFCATION DE L INTERVENTION PROVIENT FICHE AFFAIRE PRENDRE EN CHARGE*********
    if (!empty($_GET['id'])) {//id intervention
        $id_affaire = $visiteur->getMemNextAction(); //on récupérer l'id affaire
        $recup_inter = new Intervention();
        $form_input = $recup_inter->recupInter($_GET['id']); //RECHERCHER L INTERVENTION A MODIFIER
        $visiteur->setInputForm($form_input);
        $submit = "modifier intervention";
        $visiteur->setModeModifier();
    }

//********************GET = PROVIENT DE LA PAGE DIRECTE MES INTERVENTIONS AJOUTER INTEVENTION*********
    if (!empty($_GET['id_affaire_tech']) && isset($_GET['crypt'])) {
        //on récupère l'affaire depuis le get
        $recup_affaire = new Affaire($_GET['crypt']);
        $id_affaire = $_GET['id_affaire_tech'];
        $affaire_tech = $recup_affaire->recupficheAffaire($_GET['id_affaire_tech']);
        $visiteur->setResultFind($affaire_tech);
        $visiteur->setModeAjouter();
        $submit = "ajouter intervention";
    }

    //DETERMINE LE NOM DU BOUTON, PRIS EN CHARGE DE L APPAREIL OU NOUVELLE INTERVENTION 
    $inter = new Intervention();
    $intervention = $inter->listeInter($id_affaire);
    if (empty($intervention)) {
        $titre_inter = "prendre en charge l'appareil";
        $submit = "prendre en charge";
    } else {
        $titre_inter = "ajouter une intervention";
    }
    ?>

    <div class="affaire">
<?php
//**********************AFFICHAGE DES INFORMATIONS SUR L APPAREIL ET LE CLIENT*********************************
$data_aff = $visiteur->getResultFind(); //récupération des donnnées affaire depuis la page fiche reception affaire
echo "<h2>numéro affaire " . $id_affaire . "  </h2>";
?>
        <h3>intervention du technicien  :  <?php echo $visiteur->getNomVisiteur() ?></h3>
        <b>appareil</b> <?php echo $data_aff->reference ?> </h3>
        <b> numero de serie</b>  <?php echo $data_aff->numero_serie ?><br/>
        <b>localisation </b> <?php echo $data_aff->localisation ?><br/>
        <b>client:</b>  <?php echo $data_aff->nom ?><br/>
        <b>remarque  </b> <?php echo $data_aff->remarque ?><br/>
    </div>

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

    <h1><a href="../technique/ajouter_intervention.php?add_inter=plus">Ajouter une autre intervention</a></h1>
    <h1><a href="cloture_inter.php">réparation terminé</a></h1>

</article>

</section>

<aside><!-- balise aside fermante dans le footer -->

    <h3>piece consommée</h3>
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
    <div class="totaux">
        <?php
        
        echo "total prix pièce =" . $piece_ht_total . " total heure:" . $duree_total . "<br/>";
        echo " = " . $piece_ht_total + ($duree_total * 80) . "euros (80/heures)";
        ?>
        </div>
        <?php

        $html->footer();
        ?>
