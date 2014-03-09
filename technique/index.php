<?php
require_once '../lib/Ini.php'; //INDEX MENU TECHNICIEN
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application
//propose qu'un seul menu
$menu[0] =  array ('url' => '../technique/tech_intervention.php?crypt='.$visiteur->getCrypt(),'lien' => 'mes interventions');

//*************************************** PREPARTATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/tech.css">'); //ajouter le css admin
$html->banniere('technique :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$menu_courrant  = $start->filtreMenu($menu,"technique");//filtre seulement menu de la page courrant
$html->navMenu($menu_courrant, 'menu_action'); //MENU ACTION LATTERAL GAUCHE
?>
<article>
    <?php

echo "<h1>Liste attente intervention technicien </h1>";
$pris_encharge = new Affaire(NULL);
$liste_affaire = $pris_encharge->listeAffaire($visiteur->getCrypt());
//*************************************** AFFICHAGE DES LISTES AFFAIRE****************************************
?>
<table>
    <?php
    foreach ($liste_affaire as $A) {
        ?>
        <tr>
           
            <td><?php echo $A->date ?></td>
            <td><?php echo $A->nom_client ?> </td>
            <td> <?php echo $A->reference ?></td>
            <td><a href="../reception/fiche_affaire.php?id_affaire=<?php echo $A->id?>">fiche affaire</a></td>
            <td><a href="#">annuler</a></td>
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



