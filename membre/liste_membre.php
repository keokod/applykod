<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$visiteur->clearInputForm();
$visiteur->clearRecherche();

$crypt = $visiteur->getCrypt();

if (isset($_GET['type'])) {//le get permet de savoir client ou employé
    $visiteur->setMenuConcerne($_GET['type']);
    $visiteur->refreshVisiteur();
} else {
    $_GET['type'] = 'collaborateur';
}

$visiteur->InitialMod(); //on initialise à zero les mods(modif ou ajouter)
$start = new startIndex($visiteur, 51); //5 = ADMINISTRATION
if (!in_array('FF', $visiteur->getHexaAuthVisiteur())) {//si ce n'est pas un SU directe erreur
    Route::routage(8003); //redirection erreur
}

$menu = $start->getLienMenu();
$html = new Html("CLIENT : ");
$html->banniere('Menu Application SAV');
$html->navCategorie($start->getLienCategorie());
$menu_courrant = $start->filtreMenu($menu, "membre"); //filtre seulement menu de la page courrant qui concerne membre
$html->navMenu($menu_courrant, 'menu_action'); //MENU ACTION LATTERAL GAUCHE
?> 

<article>
    <h2>20 derniers <?php echo $_GET['type'] ?> inscrits </h2>
    <?php
    $membre = new Membre();
    $liste_membre = $membre->listeMembre($_GET['type']);
    ?>
    <table>
        <th>nom</th><th>nom</th><th>prenom</th><th>type utilisateur </th>
        <?php
        foreach ($liste_membre as $L) {
            ?>
            <tr>
                <td><?php echo $L->email ?></td>
                <td><?php echo $L->nom ?></td>
                <td><?php echo $L->prenom ?></td>
                <td><?php echo $L->type_user ?></td>
                <td>
                    <a href="../membre/fiche_membre.php?id_voir_membre=<?php echo $L->id ?>">detail</a>
                </td>
                <td> <a class="kill" href="../membre/kill_membre.php?id_kill_membre=<?php echo $L->id . '&crypt=' . $crypt ?>">X</a></td>
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