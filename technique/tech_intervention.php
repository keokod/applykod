<?php
require_once '../lib/Ini.php'; //LIST DES AFFAIRES DU TECHNICEN
$visiteur = $_SESSION['visiteur'];
$id_tech = $visiteur->getIdVisiteur();
$start = new startIndex($visiteur, 1); //1 = menu application
//propose qu'un seul menu

//*************************************** PREPARTATION DE LA PAGE HTML + MENU PROJET STEPHANE NGOV****************************************
$html = new Html('recherche piece');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/tech.css">'); //ajouter le css admin
$html->banniere('recherche piece');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>

<article>
    
<a href="#null" onclick="javascript:history.back();">Précédent</a>
<?php
$recup_affaire_tech = new Affaire($_GET['crypt']);
$affaire_tech = $recup_affaire_tech->listeAffaireTech($id_tech);
echo "<h1>Liste de mes interventions </h1>";

//*************************************** AFFICHAGE DES LISTES AFFAIRE****************************************
?>
<table>
    <?php
    foreach ($affaire_tech  as $A) {
        ?>
        <tr>
            <td><b>affaire <?php echo $A->id ?> : </b></td>  
            <td><?php echo $A->date ?></td>
            <td><?php echo $A->nom_client ?> </td>
            <td> <?php echo $A->reference ?></td>
            <td><a href="../technique/fiche_intervention.php?id_affaire_tech=<?php echo $A->id.'&crypt='.$visiteur->getCrypt()?>">fiche affaire</a></td>
            <td><a href="#">annuler</a></td>
        </tr>
        <?php
    }
    ?>
</table>

    </article>

</section>
<aside><!-- balise aside fermante dans le footer -->
    <?php
    $html->footer();
    ?>
