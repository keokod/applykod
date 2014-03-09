<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application
$menu = $start->getLienMenu();
$visiteur->clearRecherche(); //on efface les résultats des recherches

$visiteur->setModeModifier(); //on se met en mode modifié pour les prochahin liens cliqué
//*************************************** PREPARTATION DE LA PAGE HTML + MENU PROJET STEPHANE NGOV ****************************************
$html = new Html("RECEPTION :");
$html->banniere('receptionniste');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/affaire.css">'); //ajouter le css admin}
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>

    <a href="#null" onclick="javascript:history.back();">Précédent</a>
    <?php
    $fiche_affaire = new Affaire($visiteur->getCrypt());
    if (isset($_GET['id_affaire'])) {
        $id_fiche_affaire = $_GET['id_affaire'];
        $visiteur->setMemNextAction($_GET['id_affaire']); //on mémoire id affaire couant
        $visiteur->setNextRoute(4002); //4002 pour revenir à la fiche affaire 
    } else {
        $id_fiche_affaire = $visiteur->getMemNextAction();
    }

    $data = $fiche_affaire->recupficheAffaire($id_fiche_affaire);
    //recherche du nom du receptionniste
    $nom_receptionniste = new Membre();
    $nom_receptionniste->hydrateMembre($data->id_receptionniste);
    ?>

    <h1>affaire numéro <?php echo $id_fiche_affaire ?> pour le client : <?php echo $data->nom ?></h1>
    <div class="affaire">
        <h5>date de création: <?php echo $data->date ?></h5>

        <h5>réceptionniste : <?php echo $nom_receptionniste->getNom() ?></h5>

        <h4>remarque client:</h4>
        <span><?php echo $data->remarque ?></span>

        <h2>client</h2>
        <table>
            <tr>
                <td>nom:</td><td><?php echo $data->nom ?></td>
            </tr>
            <tr>
                <td>prenom:</td><td><?php echo $data->prenom ?></td>
            </tr>
            <tr>
                <td>adresse:</td><td><?php echo $data->adresse ?></td>
            </tr>
            <tr>
                <td>adresse:</td><td><?php echo $data->telephone ?></td>
            </tr>
        </table>
    </div>

    <?php
    $form_edit = new Form('../reception/ajouter_affaire.php?id_affaire=' . $id_fiche_affaire . '&&crypt=' . $visiteur->getCrypt(), 'editer', 'editer');
    $form_edit->endForm('editer fiche');
    ?>
</article>
</section>
<aside>

        <h4>appareil </h4>
        <ul class="appareil">
            <li><b>référence:  </b><?php echo $data->reference ?> </li>
            <li><b>numéro de série: </b> <?php echo $data->numero_serie ?></li>
            <li><b>localisation : </b><?php echo$data->localisation ?></li>
        </ul>


            <?php
            if ($visiteur->getTypeUserVisiteur() == 'technique') {
                //on recuper la fiche de l'affaire
                $visiteur->setResultFind($data); //on récupère la fichiers selectionner
                ?>
                <h1>
                    <a href="../technique/ajouter_intervention.php?id_affaire_tech=<?php echo $id_fiche_affaire . '&crypt=' . $visiteur->getCrypt() ?>"> => Réparation</a>
                </h1>
                <?php
            }
            $html->footer();
            ?>