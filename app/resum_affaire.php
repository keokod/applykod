<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$crypt = $visiteur->getCrypt();
$html = new Html("Résumer des interventions");
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/client.css">'); //ajouter le css admin
$html->banniere('Menu Application SAV');
?>
<article>

    <h1>Liste de 1 ou plusieurs intervention de voter appareil</h1>

    <INPUT type="button" value="Précédent" onclick="history.back()">
    <?php
    $id_affaire = $_GET['id_affaire'];
    $intervention = new Intervention();
    $inter = $intervention->listeInter($id_affaire);
    echo '<table>';
    echo '<th>date intervention </th><th>tâche</th><th>diagnostique du technicien</th>';
    foreach ($inter as $I) {
        echo '<tr>';
        echo '<td>' . $I->date_inter . '</td>';
        echo '<td>' . $I->tache . '</td>';
        echo '<td>' . $I->diagnostique . '</td>';
        echo '<td>';
        switch ($I->etat) {
            case 1:
                echo "estimation";
                break;
            case 2:
                echo "en cours";
                break;
            case 3:
                echo "terminer";
                break;
            case 4:
                echo "annuler";
                break;
            default :
                echo "nom pris en charge";
                break;
        }
        echo '</td>';
    }
    echo '</table>';    
    ?>
</article>
</section>

    <?php
    $html->footer();
    ?>