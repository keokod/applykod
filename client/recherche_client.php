<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$visiteur->setNextRoute(1005); //revenir à cette page pour les résultats recherche membre
$visiteur->setModeAjouter();
$type_user_visiteur = $visiteur->getTypeUserVisiteur();
$start = new startIndex($visiteur, NULL); //context 12 rechercher un client
$menu = $start->getLienMenu(); //récupère les menu vertical à gauche

//pérparation des cheeksbox
$html = new Html("RECEPTION :");
$html->banniere('receptionniste');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/affaire.css">'); //ajouter le css admin}
$html->navCategorie($start->getLienCategorie()); //on récupère le menu par role
$menu_courrant  = $start->filtreMenu($menu,"client");//filtre seulement menu de la page courrant
$html->navMenu($menu_courrant, 'menu_action'); //MENU ACTION LATTERAL GAUCHE
?>
<article>
    <?php
    if ($visiteur->getFlashInfo() != NULL) {
        echo $visiteur->getFlashInfo();
    }
    $form_find_membre = new FormRechercheClient();
    $form_find_membre->endForm('recherche client');
    if ($visiteur->getResultFind() != NULL) {
        echo '<div class="resultat">';
        echo '<h4>Resultat :</h4>';
        if (is_array($visiteur->getResultFind())) {
            $find_membre = $visiteur->getResultFind(); //si on a un résultat on l'affiche 
            ?>
            <table>
                <tr>
                    <th>email</th><th>nom</th><th>prenom</th>
                </tr>
                <?php
                foreach ($find_membre as $F) {
                    ?>
                    <tr>
                        <td><?php echo $F->email ?></td><td><?php echo $F->nom ?></td><td><?php echo $F->prenom ?></td>
                        <td><a href="../reception/ajouter_affaire.php?id_client=<?php echo $F->id ?>"> + affaire</a></td>
                        <td><a href="../client/fiche_client.php?id_client=<?php echo $F->id . "&crypt=" . $visiteur->getCrypt() ?>  "> détail </a></td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
        <?php
    }
}
?>
</article>
</section>
<aside>

    <?php
    echo $visiteur->getErreur();
    $html->footer();
    ?>