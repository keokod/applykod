<?php
require_once'../lib/Ini.php';

$visiteur = $_SESSION['visiteur'];

$visiteur->clearResultat(); //on n'a pas besion des résultats des recherches client
extract($_GET);
$id_client = 44;
$visiteur->setMemNextAction($id_client); //on garde id client pour affichier la fiche affaire
$liste_affaire = new Affaire($crypt);
$data = $liste_affaire->resumAffaireClient($id_client);
?>
<h1>Affaire avec le client <?php echo $nom_client ?></h1>
<table>
    <th>date</th><th>appareil</th><th>numero affaire</th><th>annuler</th><th>terminer</th><th>détail affaire</th>
    <?php
    foreach ($data as $D) {
        ?>
        <tr>
            <td><?php echo $D->date ?></td>
            <td><?php echo $D->reference ?></td>
            <td><?php echo $D->id ?></td>
            <td><?php echo $D->annuler ?></td>
            <td><?php echo $D->terminer ?></td>
            <td><a href="fiche_affaire.php?id_affaire=<?php echo $D->id."&crypt=".$crypt?>">detail</a></td>
        </tr>
        <?php
    }
    ?>
</table>