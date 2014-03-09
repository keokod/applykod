<?php
require_once '../lib/Ini.php';
//on recupère le get context
$visiteur = $_SESSION['visiteur'];
$visiteur->clearInputForm();
$visiteur->clearRecherche();
$visiteur->setModeModifier(); //se mettre en mode modifier pour le mode edition

if (isset($_GET['id_voir_membre'])) {//si on a cliquer le lien voir membre sur la liste
    $visiteur->setMemNextAction($_GET['id_voir_membre']); //on enregistre le numéro de la fiche pour le mode edition 
    $id_membre = $_GET['id_voir_membre'];
} else {//sinon on vient de l'enqistrer , on récupère son numéro qui à été charger par le class inscription
    $id_membre = $visiteur->getMemNextAction();
}

$hexa_auth_visiteur = $visiteur->getHexaAuthVisiteur();
//le fiche employé réserver au SU
if (!in_array('FF', $hexa_auth_visiteur)) {//seul le SU peut accès au employer
    Route::routage(8001); //redirection erreur
}

if (in_array('10', $hexa_auth_visiteur)) {//seul le SU peut accès au employer
    Route::routage($visiteur->getNextRoute()); //enregistrement receptionniste route vers reception/ajouter_affaire.php
}

//initialise les actions
$kill = "";
$editer = "";

$voir_membre = new Membre();

//************ EN CAS OU L ON SOUHAITE MODIFIER LE MEMBRE
$voir_membre->hydrateMembre($id_membre);
$membre_modif = $voir_membre->allAtribut(); //on récupère les date du membre
//************  RECUPERATION DES DATAS DU MEMBRE    

$type_user_concerne = $membre_modif['type_user']; //on récupère le type de membre
$fiche_email = $membre_modif['email'];
$fiche_civilite = $membre_modif['civilite'];
$fiche_nom = $membre_modif['nom'];
$fiche_prenom = $membre_modif['prenom'];
$fiche_telephone = $membre_modif['telephone'];
$fiche_adresse = $membre_modif['adresse'];
$fiche_hexa_auth = $membre_modif['hexa_auth'];
$type_user = $membre_modif['type_user'];
//en cas de modification du membre on récupère

$start = new startIndex($visiteur, 5); //5 = ADMINISTRATION
//DEMARRAGE PAGE HTML
$menu = $start->getLienMenu();
$html = new Html("CLIENT : ");
$html->banniere('Menu Application SAV');
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>

    <?php if (in_array('FF', $hexa_auth_visiteur) || in_array('1F', $hexa_auth_visiteur)) {//si on a les droits de supprimer on affiche le lien ?>

        <h2>fiche <?php echo $type_user_concerne . ' ' . $membre_modif['nom'] . ' ' . $membre_modif['prenom'] ?></h2>
        <span>Lors de l'inscription de ce membre , ses identifants ont été envoyé à son adresse </span>
        
        <?php
        $crypt = $visiteur->getCrypt();
        $kill = '<a class="kill" href="../membre/kill_membre.php?id_kill_membre=' . $id_membre . '&crypt=' . $crypt . '">supprimer le ' . $type_user_concerne . '</a>';
        $_SESSION['membre_a_modif'] = $id_membre;

        //appelle activation du mode edtion de la fiche membre

        $mode_edition = new Form('../membre/ajouter_membre.php', NULL, 'edit'); //pas de titre 
        ?>
        <table>
            <tr>
                <td>email :</td><td><?php echo $fiche_email ?></td>
            </tr>
            <tr>
                <td>civilite :</td><td><?php echo $fiche_civilite ?></td>
            </tr>
            <tr>
                <td> nom:</td><td><?php echo $fiche_nom ?></td>
            </tr>
            <tr>
                <td>prenom :</td><td><?php echo $fiche_prenom ?></td>     
            </tr>
            <tr>
                <td>telephone:</td><td><?php echo $fiche_telephone ?></td>
            </tr>
            <tr>
                <td>adresse:</td><td><?php echo $fiche_adresse ?></td>
            </tr>
            
            <tr>
                <td>son type utillisateur </td><td><?php echo $type_user ?></td> 
            </tr>
        </table>

        <?php

    }
    ?>

</article>

</section>
<aside><!-- balise aside fermante dans le footer -->
<?php
        $mode_edition->endForm('Mode edition'); //bouton mode edition
        
        if ($fiche_hexa_auth[0] != NULL) {
		    ?> <ul id="role">
			<?php
                        $autorise = new Autorise();
                        
            foreach ($fiche_hexa_auth as $H) {
                ?>
                <li><span>
                        <?php
                       // var_dump($H);
                        $description = $autorise->listeAuth($H);
                        echo $description;
                        ?>
                        
                        
                    </span> (<?php echo $H ?>)</li> 
                <?php
            }
			?>
			<ul>
		<?php
	
        }


    $html->footer();
    ?>
