<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$visiteur->setNextRoute(7005); //revenir à cette page pour les résultats recherche membre
$type_user_visiteur = $visiteur->getTypeUserVisiteur();
$start = new startIndex($visiteur, 51); //context 12 rechercher un client
//DEMARRAGE PAGE HTML
$menu = $start->getLienMenu();
$html = new Html("RECHERCHE : ");

//pérparation des cheeksbox
if ($type_user_visiteur == "SU") {
    $html->banniere('administrateur');
}
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>
    <?php
    if ($type_user_visiteur == "SU") {//si c'est un su on recherche client ou employé
        $form_find_membre = new FormRechercheMembre();
        $form_find_membre->choixTypeMembre();
        $form_find_membre->endForm('recherche membre');
    } else {//pour un compte normal on ne peut que rechercher un client
        $form_find_membre = new FormRechercheClient();
        $form_find_membre->endForm('recherche client');
    }


    if ($visiteur->getResultFind() != NULL) {
        $find_membre = $visiteur->getResultFind();
        ?>
        <h1>resultat recherche</h1>
        <div class="resultat">
            <table>
                <tr>
                    <th>email</th><th>nom</th><th>prenom</th><th>type user</th><th>action</th>
                </tr>
                <?php
                foreach ($find_membre as $F) {
                    ?>
                    <tr>
                        <td><?php echo $F->email ?></td><td><?php echo $F->nom ?></td><td><?php echo $F->prenom ?></td>
                        <?php
                        if ($F->type_user == 'client') {
                            echo '<td><a href="../reception/ajouter_affaire.php?id_client=' . $F->id . '">ajouter_affaire</a></td>';
                        }
                        ?>
                        <td><a href="../membre/ajouter_membre.php?id_membre=<?php echo $F->id ?>"> modifier<a></td>
                                    <td><?php echo $F->type_user ?></td>
                                    </tr>
    <?php } ?>
                                </table>
                                </div>
                            <?php
                            } else {
                                if (!empty($_POST['mot_cle'])) {
                                    ?><h3>introuvable</h3>
    <?php }
}
?>
                            </article>
                            </section>
                            <aside><!-- balise aside fermante dans le footer -->
<?php $html->footer(); ?>
