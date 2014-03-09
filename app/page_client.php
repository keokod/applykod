<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$crypt = $visiteur->getCrypt();
$html = new Html("Listes des membres");
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/client.css">'); //ajouter le css admin
$html->banniere('Menu Application SAV');
?>
<article>

<?php
$id_client = $visiteur->getIdVisiteur();
$membre = new Membre();
$membre->hydrateMembre($id_client);
$attribut = $membre->allAtribut();
extract($attribut);
?>
    <h3>Compte : <?php echo "nom:" . $prenom . " prenom: " . $nom ?></h3>

    email : <?php echo $email ?><br/>        
    adresse : <?php echo $adresse ?><br/>

    <h3>Vos appareil</h3>

<?php
$affaire = new Affaire($crypt);
$resumer = $affaire->resumAffaireClient($id_client);

?>
    <table>
        <td>numéro d'enregistrement</td><td>date</td><td>reference</td><td>etat  </td><td>receptionniste</td>
    <?php
    foreach ($resumer as $R) {
        $etat = NULL;
        if ($R->annuler == 1) {
            $etat = "Annuler";
        } else {
            $etat = "en cour";
        }
        if ($R->terminer == 1) {
            $etat = "Terminer";
        } else {
            $etat = "en cour";
        }
        echo '<tr>';
        echo '<td>' . $R->id . "</td>";
        echo '<td>' . $R->date . "</td>";
        echo '<td>' . $R->reference . "</td>";
        echo '<td>' . $etat . '</td>';
         //recherche du nom du receptionniste
        $membre = new Membre();
        $membre->hydrateMembre($R->id_receptionniste);//récupère du nom du receptionniste
        echo '<td> '.$membre->getNom().'</a></td>';   
     	echo '<td><a href="resum_affaire.php?id_affaire='.$R->id.' "> détail</a></td>';
        echo '</tr>';
    }
    ?>
    </table>
</article>
</section>
        <?php
        $html->footer();
        ?>