<?php
require_once '../lib/Ini.php'; // FICHE CLIENT

$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application
$menu = $start->getLienMenu();

//*************************************** PREPARTATION DE LA PAGE HTML + MENU****************************************
$html = new Html("RECEPTION :");
$html->banniere('receptionniste');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/affaire.css">'); //ajouter le css admin}
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu_action'); //MENU ACTION
$visiteur->setModeModifier(); //se mettre en mode modifier
?>
<article>
    <?php
    $visiteur->setMemNextAction($_GET['id_client']); //on garde le numéro du client pour revenir à sa fiche
    //  $visiteur->setNextRoute(1001);//pour revenir a la fiche client 
    echo '<h2>Fiche client :</h2>';

    $membre = new Membre();
    $membre->hydrateMembre($_GET['id_client']);
    $client = $membre->allAtribut();
    ?>
    <label>Nom :</label><?php echo $client['nom'] ?><br/>
    <label>Prénom :</label><?php echo $client['prenom'] ?><br/>
    <label>email :</label><?php echo $client['email'] ?><br/>
    <label>adresse :</label><?php echo $client['adresse'] ?><br/> 
    <label>telephone :</label><?php echo $client['telephone'] ?><br/> 
    <?php
    $affaire = new Affaire($_GET['crypt']);
    $all_affaire = $affaire->resumAffaireClient($_GET['id_client']);
    ?>
    <table> 

        <a href="../membre/ajouter_membre.php?id_membre=<?php echo $_GET['id_client'] ?>">modifier membre</a>

        <h2>historique des affaires avec ce client</h2>

        <?php
        foreach ($all_affaire as $A) {
            ?>
            <tr>
                <td><?php echo $A->date ?></td>
                <td><a href="../reception/fiche_affaire.php?id_affaire=<?php echo $A->id ?>">fiche affaire</a></td>
                <td><?php echo $A->reference ?></a></td>
                <td><?php echo $A->localisation ?></a></td>
                <td><a href="../reception/sortir_appareil.php?id_appareil=<?php echo $A->id_appareil?>">sotir appareil</a></td>
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
    







